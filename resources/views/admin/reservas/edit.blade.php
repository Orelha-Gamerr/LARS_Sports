@extends('layouts.admin')

@section('title', 'Editar Reserva')

@section('page-title', 'Editar Reserva')
@section('page-subtitle', 'Alterar informações da reserva selecionada')

@section('admin-content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quadra *</label>
                <select name="quadra_id" id="quadra_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Selecione uma quadra</option>
                    @foreach($quadras as $quadra)
                        <option value="{{ $quadra->id }}" 
                            {{ $quadra->id == $reserva->quadra_id ? 'selected' : '' }}
                            data-preco="{{ $quadra->preco_hora }}">
                            {{ $quadra->nome }} - R$ {{ number_format($quadra->preco_hora, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cliente *</label>
                <select name="cliente_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}"
                            {{ $cliente->id == $reserva->cliente_id ? 'selected' : '' }}>
                            {{ $cliente->user->name ?? $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data da Reserva *</label>
                <input type="date" name="data_reserva"
                    value="{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('Y-m-d') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Horário *</label>
                <select name="horario_id" id="horario_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Carregando horários...</option>
                    @foreach($horarios as $h)
                        <option value="{{ $h->id }}"
                            {{ $h->id == $reserva->horario_id ? 'selected' : '' }}>
                            {{ $h->horario_inicio }}@if($h->horario_fim) - {{ $h->horario_fim }}@endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Valor *</label>
                <input type="number" step="0.01" name="valor_total"
                    value="{{ $reserva->valor_total }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="pendente"    {{ $reserva->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="confirmado"  {{ $reserva->status == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="cancelado"   {{ $reserva->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="finalizado"  {{ $reserva->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                <textarea name="observacoes" rows="4"
                    class="w-full border-gray-300 rounded-lg shadow-sm">{{ $reserva->observacoes }}</textarea>
            </div>

        </div>

        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.reservas.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
               Cancelar
            </a>

            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Atualizar Reserva
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quadraSelect = document.getElementById('quadra_id');
    const horarioSelect = document.getElementById('horario_id');
    const valorInput = document.querySelector('input[name="valor_total"]');

    function carregarHorarios(quadraId) {
        if (quadraId) {
            horarioSelect.innerHTML = '<option value="">Carregando horários...</option>';
            
            fetch(`/admin/reservas/horarios/${quadraId}`)
                .then(response => response.json())
                .then(horarios => {
                    horarioSelect.innerHTML = '<option value="">Selecione um horário</option>';
                    
                    horarios.forEach(horario => {
                        const option = document.createElement('option');
                        option.value = horario.id;
                        option.textContent = horario.horario_inicio + (horario.horario_fim ? ' - ' + horario.horario_fim : '');
                        
                        if (horario.id == {{ $reserva->horario_id }}) {
                            option.selected = true;
                        }
                        
                        horarioSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar horários:', error);
                    horarioSelect.innerHTML = '<option value="">Erro ao carregar horários</option>';
                });
        } else {
            horarioSelect.innerHTML = '<option value="">Primeiro selecione uma quadra</option>';
        }
    }

    function atualizarValor() {
        const selectedOption = quadraSelect.options[quadraSelect.selectedIndex];
        const preco = selectedOption.getAttribute('data-preco');
        if (preco) {
            valorInput.value = parseFloat(preco).toFixed(2);
        }
    }

    carregarHorarios({{ $reserva->quadra_id }});

    quadraSelect.addEventListener('change', function() {
        const quadraId = this.value;
        carregarHorarios(quadraId);
        atualizarValor();
    });

    atualizarValor();
});
</script>

@endsection