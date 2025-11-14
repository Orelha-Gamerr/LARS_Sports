@extends('layouts.admin')

@section('page-title', 'Novo Pagamento')

@section('admin-content')
<div class="p-6 max-w-3xl mx-auto">

    <h1 class="text-2xl font-semibold mb-6">Registrar Pagamento</h1>

    <form action="{{ route('admin.pagamentos.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Reserva</label>
            <select name="reserva_id" class="w-full px-3 py-2 border rounded">
                <option value="">Selecione uma reserva</option>

                @foreach ($reservas as $reserva)
                    <option value="{{ $reserva->id }}"
                        {{ old('reserva_id') == $reserva->id ? 'selected' : '' }}>
                        {{ $reserva->cliente->user->name }} — {{ $reserva->quadra->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Valor</label>
            <input type="number" step="0.01" name="valor"
                   value="{{ old('valor') }}"
                   class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1 font-medium">Método de Pagamento</label>
            <select name="metodo" class="w-full px-3 py-2 border rounded">
                <option value="pix">PIX</option>
                <option value="cartao_credito">Cartão de Crédito</option>
                <option value="cartao_debito">Cartão de Débito</option>
                <option value="dinheiro">Dinheiro</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Status</label>
            <select name="status" class="w-full px-3 py-2 border rounded">
                <option value="pendente">Pendente</option>
                <option value="pago">Pago</option>
                <option value="cancelado">Cancelado</option>
                <option value="estornado">Estornado</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Código da Transação (opcional)</label>
            <input type="text" name="codigo_transacao"
                   value="{{ old('codigo_transacao') }}"
                   class="w-full px-3 py-2 border rounded">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.pagamentos.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Voltar
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Criar Pagamento
            </button>
        </div>

    </form>

</div>
@endsection
