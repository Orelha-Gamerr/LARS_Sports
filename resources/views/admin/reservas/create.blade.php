@extends('layouts.admin')

@section('title', 'Criar Reserva')

@section('page-title', 'Criar Reserva')
@section('page-subtitle', 'Cadastrar uma nova reserva no sistema')

@section('admin-content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

    <form action="{{ route('admin.reservas.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quadra</label>
                <select name="quadra_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                    @foreach($quadras as $quadra)
                        <option value="{{ $quadra->id }}">{{ $quadra->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                <select name="cliente_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data da Reserva</label>
                <input type="date" name="data_reserva"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Horário</label>
                <select name="horario_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                    @foreach($horarios as $h)
                        <option value="{{ $h->id }}">{{ $h->horario_inicio }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                <input type="number" step="0.01" name="valor_total"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
                    <option value="pendente">Pendente</option>
                    <option value="confirmado">Confirmado</option>
                    <option value="cancelado">Cancelado</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                <textarea name="observacoes" rows="4"
                    class="w-full border-gray-300 rounded-lg shadow-sm"></textarea>
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

@endsection
