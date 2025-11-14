@extends('layouts.admin')

@section('page-title', 'Detalhes do Pagamento')

@section('admin-content')
<div class="p-6 max-w-3xl mx-auto">

    <h1 class="text-2xl font-semibold mb-6">Detalhes do Pagamento</h1>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">

        <div>
            <p class="text-gray-500 text-sm">Cliente</p>
            <p class="text-lg">{{ $pagamento->reserva->cliente->user->name }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Quadra</p>
            <p class="text-lg">{{ $pagamento->reserva->quadra->nome }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Valor</p>
            <p class="text-lg">R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Método</p>
            <p class="text-lg capitalize">{{ str_replace('_', ' ', $pagamento->metodo) }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Status</p>
            <span class="px-3 py-1 rounded text-white text-sm
                @switch($pagamento->status)
                    @case('pago') bg-green-600 @break
                    @case('pendente') bg-yellow-600 @break
                    @case('cancelado') bg-red-600 @break
                    @case('estornado') bg-purple-600 @break
                @endswitch
            ">
                {{ ucfirst($pagamento->status) }}
            </span>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Código da Transação</p>
            <p class="text-lg">{{ $pagamento->codigo_transacao ?? '—' }}</p>
        </div>

    </div>

    <div class="flex justify-end mt-6">
        <a href="{{ route('admin.pagamentos.index') }}"
           class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Voltar
        </a>
    </div>

</div>
@endsection
