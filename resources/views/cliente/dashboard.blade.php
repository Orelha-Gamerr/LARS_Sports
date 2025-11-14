@extends('layouts.cliente-app')

@section('title', 'Dashboard - Reserve Quadras')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-green-800">Olá, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-600 mt-2">Encontre e reserve quadras esportivas perto de você</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Minhas Reservas</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalReservas ?? 0 }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-calendar-alt text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Confirmadas</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $reservasConfirmadas ?? 0 }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pendentes</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $reservasPendentes ?? 0 }}</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-clock text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Gasto</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">R$ {{ number_format($valorTotalGasto ?? 0, 2, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-money-bill-wave text-purple-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('cliente.quadras.index') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 hover:border-green-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-search text-green-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Buscar Quadras</h3>
                <p class="text-sm text-gray-600 mt-1">Encontre quadras disponíveis</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('cliente.reservas.create') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 hover:border-green-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-orange-100 rounded-lg">
                <i class="fas fa-plus text-orange-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Nova Reserva</h3>
                <p class="text-sm text-gray-600 mt-1">Faça uma nova reserva</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('cliente.reservas.index') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 hover:border-green-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-list text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Minhas Reservas</h3>
                <p class="text-sm text-gray-600 mt-1">Veja todas as reservas</p>
            </div>
        </div>
    </a>
</div>

<div class="mb-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-green-800">Quadras em Destaque</h2>
        <a href="{{ route('cliente.quadras.index') }}" class="text-green-600 hover:text-green-800 font-medium flex items-center">
            Ver todas
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Exemplo de quadra em destaque - você vai substituir por dados dinâmicos -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-all duration-300">
            <div class="h-40 bg-gradient-to-r from-green-400 to-green-600 relative">
                <div class="absolute top-3 right-3">
                    <span class="bg-white text-green-800 text-xs font-bold px-2 py-1 rounded-full">
                        ⭐ 4.8
                    </span>
                </div>
            </div>
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-gray-800 text-lg">Arena Sports Center</h3>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded">Society</span>
                </div>
                <p class="text-gray-600 text-sm mb-3 flex items-center">
                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                    Av. Paulista, 1000 - São Paulo
                </p>
                <div class="flex justify-between items-center">
                    <span class="text-green-800 font-bold">R$ 180/hora</span>
                    <a href="{{ route('cliente.quadras.show', 1) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition">
                        Reservar
                    </a>
                </div>
            </div>
        </div>

        <!-- Adicione mais quadras em destaque conforme necessário -->
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-bold text-green-800">Minhas Reservas Recentes</h3>
    </div>
    <div class="p-6">
        @if(isset($reservasRecentes) && $reservasRecentes->count() > 0)
            <div class="space-y-4">
                @foreach($reservasRecentes as $reserva)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-futbol text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $reserva->quadra->nome ?? 'Quadra' }}</h4>
                            <p class="text-sm text-gray-600">{{ $reserva->quadra->empresa->nome ?? 'Empresa' }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }} às {{ $reserva->horario->horario_inicio ?? '--:--' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="font-bold text-green-800">R$ {{ number_format($reserva->valor_total ?? 0, 2, ',', '.') }}</p>
                            @php
                                $statusColors = [
                                    'pendente' => 'bg-yellow-100 text-yellow-800',
                                    'confirmado' => 'bg-green-100 text-green-800',
                                    'cancelado' => 'bg-red-100 text-red-800',
                                    'finalizado' => 'bg-blue-100 text-blue-800'
                                ];
                                $status = $reserva->status ?? 'pendente';
                            @endphp
                            <span class="text-xs px-2 py-1 rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($status) }}
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('cliente.reservas.show', $reserva) }}" class="p-2 text-green-600 hover:text-green-800 transition">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($status == 'pendente')
                            <a href="{{ route('cliente.reservas.edit', $reserva) }}" class="p-2 text-blue-600 hover:text-blue-800 transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ route('cliente.reservas.index') }}" class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                    Ver todas as minhas reservas
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <div class="text-center py-8">
                <div class="p-4 bg-green-50 rounded-lg inline-block mb-4">
                    <i class="fas fa-calendar-plus text-4xl text-green-600"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Nenhuma reserva encontrada</h4>
                <p class="text-gray-600 mb-4">Você ainda não fez nenhuma reserva. Que tal encontrar uma quadra agora?</p>
                <a href="{{ route('cliente.quadras.index') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition inline-flex items-center">
                    <i class="fas fa-search mr-2"></i>
                    Buscar Quadras
                </a>
            </div>
        @endif
    </div>
</div>
@endsection