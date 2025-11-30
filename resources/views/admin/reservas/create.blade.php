@extends('layouts.admin')

@section('title', 'Criar Reserva')

@section('page-title', 'Criar Reserva')
@section('page-subtitle', 'Cadastrar uma nova reserva no sistema')

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

    <form action="{{ route('admin.reservas.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quadra *</label>
                <select name="quadra_id" id="quadra_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Selecione uma quadra</option>
                    @foreach($quadras as $quadra)
                        <option value="{{ $quadra->id }}" data-preco="{{ $quadra->preco_hora }}">
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
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->user->name ?? $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data da Reserva *</label>
                <input type="date" name="data_reserva" value="{{ old('data_reserva') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Horário *</label>
                <select name="horario_id" id="horario_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Primeiro selecione uma quadra</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                <textarea name="observacoes" rows="4"
                    class="w-full border-gray-300 rounded-lg shadow-sm">{{ old('observacoes') }}</textarea>
            </div>

        </div>

        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.reservas.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
               Cancelar
            </a>

            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Salvar Reserva
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quadraSelect = document.getElementById('quadra_id');
    const horarioSelect = document.getElementById('horario_id');

    quadraSelect.addEventListener('change', function() {
        const quadraId = this.value;
        
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
    });
});
</script>

@endsection