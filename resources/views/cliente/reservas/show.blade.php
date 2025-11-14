@extends('layouts.cliente-app')

@section('title', 'Detalhes da Reserva - Reserve Quadras')

@section('content')
<div class="mb-6">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('cliente.reservas.index') }}" class="text-green-600 hover:text-green-800">Minhas Reservas</a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Detalhes</span>
                </div>
            </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-green-800">Detalhes da Reserva</h1>
    <p class="text-gray-600 mt-2">Informações completas sobre sua reserva</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Informações da Reserva -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-green-800">Informações da Reserva</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    @php
                        $statusColors = [
                            'pendente' => 'bg-yellow-100 text-yellow-800',
                            'confirmado' => 'bg-green-100 text-green-800',
                            'cancelado' => 'bg-red-100 text-red-800',
                            'finalizado' => 'bg-blue-100 text-blue-800'
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded-full {{ $statusColors[$reserva->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($reserva->status) }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Data:</span>
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Horário:</span>
                    <span class="font-semibold">{{ $reserva->horario->horario_inicio }} - {{ $reserva->horario->horario_fim }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Valor:</span>
                    <span class="font-semibold text-green-800">R$ {{ number_format($reserva->valor_total, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Código da Reserva:</span>
                    <span class="font-semibold">{{ $reserva->codigo_reserva }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Data da Reserva:</span>
                    <span class="font-semibold">{{ $reserva->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações da Quadra -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-green-800">Informações da Quadra</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Quadra:</span>
                    <span class="font-semibold">{{ $reserva->quadra->nome }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Modalidade:</span>
                    <span class="font-semibold">{{ $reserva->quadra->modalidade }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Localização:</span>
                    <span class="font-semibold text-right">{{ $reserva->quadra->endereco }}, {{ $reserva->quadra->cidade }}-{{ $reserva->quadra->estado }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Telefone:</span>
                    <span class="font-semibold">{{ $reserva->quadra->telefone }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ações -->
@if($reserva->status == 'pendente')
<div class="mt-6 flex space-x-4">
    <a href="{{ route('cliente.reservas.edit', $reserva) }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
        <i class="fas fa-edit mr-2"></i>Editar Reserva
    </a>
    <form action="{{ route('cliente.reservas.destroy', $reserva) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition" onclick="return confirm('Tem certeza que deseja cancelar esta reserva?')">
            <i class="fas fa-times mr-2"></i>Cancelar Reserva
        </button>
    </form>
</div>
@endif
@endsection