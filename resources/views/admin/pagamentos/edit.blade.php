@extends('layouts.admin')

@section('page-title', 'Editar Pagamento')

@section('admin-content')
<div class="p-6 max-w-3xl mx-auto">

    <h1 class="text-2xl font-semibold mb-6">Editar Pagamento</h1>

    <form action="{{ route('admin.pagamentos.update', $pagamento) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Reserva</label>
            <select name="reserva_id" class="w-full px-3 py-2 border rounded">
                @foreach ($reservas as $reserva)
                    <option value="{{ $reserva->id }}"
                        {{ $pagamento->reserva_id == $reserva->id ? 'selected' : '' }}>
                        {{ $reserva->cliente->user->name }} — {{ $reserva->quadra->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Valor</label>
            <input type="number" step="0.01" name="valor"
                   value="{{ $pagamento->valor }}"
                   class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1 font-medium">Método de Pagamento</label>
            <select name="metodo" class="w-full px-3 py-2 border rounded">
                <option value="pix" {{ $pagamento->metodo == 'pix' ? 'selected' : '' }}>PIX</option>
                <option value="cartao_credito" {{ $pagamento->metodo == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                <option value="cartao_debito" {{ $pagamento->metodo == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                <option value="dinheiro" {{ $pagamento->metodo == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Status</label>
            <select name="status" class="w-full px-3 py-2 border rounded">
                <option value="pendente" {{ $pagamento->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="pago" {{ $pagamento->status == 'pago' ? 'selected' : '' }}>Pago</option>
                <option value="cancelado" {{ $pagamento->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                <option value="estornado" {{ $pagamento->status == 'estornado' ? 'selected' : '' }}>Estornado</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Código da Transação</label>
            <input type="text" name="codigo_transacao"
                   value="{{ $pagamento->codigo_transacao }}"
                   class="w-full px-3 py-2 border rounded">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.pagamentos.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Voltar
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Atualizar Pagamento
            </button>
        </div>

    </form>

</div>
@endsection
