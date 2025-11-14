@extends('layouts.cliente-app')

@section('title', 'Detalhes do Pagamento - Reserve Quadras')

@section('content')
<div class="mb-6">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('cliente.pagamentos.index') }}" class="text-green-600 hover:text-green-800">Meus Pagamentos</a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Detalhes</span>
                </div>
            </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-green-800">Detalhes do Pagamento</h1>
    <p class="text-gray-600 mt-2">Informações completas sobre seu pagamento</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Informações do Pagamento -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-green-800">Informações do Pagamento</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    @php
                        $statusColors = [
                            'pendente' => 'bg-yellow-100 text-yellow-800',
                            'pago' => 'bg-green-100 text-green-800',
                            'cancelado' => 'bg-red-100 text-red-800'
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded-full {{ $statusColors[$pagamento->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($pagamento->status) }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Valor:</span>
                    <span class="font-semibold text-green-800">R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Método de Pagamento:</span>
                    <span class="font-semibold">{{ ucfirst($pagamento->metodo_pagamento) }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Data do Pagamento:</span>
                    <span class="font-semibold">{{ $pagamento->data_pagamento ? \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y H:i') : 'N/A' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Código da Transação:</span>
                    <span class="font-semibold">{{ $pagamento->codigo_transacao ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações da Reserva -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-green-800">Reserva Relacionada</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Código da Reserva:</span>
                    <span class="font-semibold">{{ $pagamento->reserva->codigo_reserva }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Quadra:</span>
                    <span class="font-semibold">{{ $pagamento->reserva->quadra->nome }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Data:</span>
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($pagamento->reserva->data_reserva)->format('d/m/Y') }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Horário:</span>
                    <span class="font-semibold">{{ $pagamento->reserva->horario->horario_inicio }} - {{ $pagamento->reserva->horario->horario_fim }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ações -->
@if($pagamento->status == 'pendente')
<div class="mt-6">
    <a href="#" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition">
        <i class="fas fa-credit-card mr-2"></i>Pagar Agora
    </a>
</div>
@endif
@endsection