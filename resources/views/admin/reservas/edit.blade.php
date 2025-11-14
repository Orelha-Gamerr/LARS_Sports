@extends('layouts.admin')

@section('title', 'Editar Reserva')

@section('page-title', 'Editar Reserva')
@section('page-subtitle', 'Alterar informações da reserva selecionada')

@section('admin-content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

    <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quadra</label>
                <select name="quadra_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                    @foreach($quadras as $quadra)
                        <option value="{{ $quadra->id }}" 
                            {{ $quadra->id == $reserva->quadra_id ? 'selected' : '' }}>
                            {{ $quadra->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                <select name="cliente_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}"
                            {{ $cliente->id == $reserva->cliente_id ? 'selected' : '' }}>
                            {{ $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data da Reserva</label>
                <input type="date" name="data_reserva"
                    value="{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('Y-m-d') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Horário</label>
                <select name="horario_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                    @foreach($horarios as $h)
                        <option value="{{ $h->id }}"
                            {{ $h->id == $reserva->horario_id ? 'selected' : '' }}>
                            {{ $h->horario_inicio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                <input type="number" step="0.01" name="valor_total"
                    value="{{ $reserva->valor_total }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
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

@endsection
