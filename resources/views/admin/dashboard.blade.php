@extends('layouts.admin')

@section('page-title', 'Dashboard Administrativo')

@section('admin-content')
<div class="mb-6 flex items-center space-x-4">
    <div class="p-3 bg-blue-100 rounded-lg">
        <i class="fas fa-futbol text-2xl text-blue-600"></i>
    </div>
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard - {{ $empresa->nome }}</h1>
        <p class="text-gray-600">Visão geral da sua empresa no Reserve Quadras</p>
    </div>
</div>

{{-- MÉTRICAS PRINCIPAIS --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total de Reservas</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalReservas }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Reservas Confirmadas</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $reservasConfirmadas }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total de Clientes</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalClientes }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 text-orange-500">
                <i class="fas fa-map-marker-alt text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total de Quadras</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalQuadras }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $quadrasAtivas }} ativas</p>
            </div>
        </div>
    </div>
</div>

{{-- LINKS RÁPIDOS --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('admin.reservas.index') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:shadow-md transition-all duration-300 hover:border-blue-300">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-calendar-alt text-blue-600"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Gerenciar Reservas</h3>
                <p class="text-xs text-gray-600 mt-1">Ver todas as reservas</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.clientes.index') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:shadow-md transition-all duration-300 hover:border-green-300">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="fas fa-users text-green-600"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Clientes</h3>
                <p class="text-xs text-gray-600 mt-1">Gerenciar clientes</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.quadras.index') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:shadow-md transition-all duration-300 hover:border-orange-300">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-orange-100 rounded-lg">
                <i class="fas fa-map-marker-alt text-orange-600"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Quadras</h3>
                <p class="text-xs text-gray-600 mt-1">Gerenciar quadras</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.relatorios.index') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:shadow-md transition-all duration-300 hover:border-purple-300">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-purple-100 rounded-lg">
                <i class="fas fa-chart-bar text-purple-600"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Relatórios</h3>
                <p class="text-xs text-gray-600 mt-1">Ver relatórios</p>
            </div>
        </div>
    </a>
</div>

{{-- INFORMAÇÕES DA EMPRESA --}}
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Informações da Empresa</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">{{ $empresa->nome }}</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-blue-500"></i>
                        {{ $empresa->email }}
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-phone mr-2 text-green-500"></i>
                        {{ $empresa->telefone ?? 'Não informado' }}
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        {{ $empresa->endereco ?? 'Endereço não informado' }}
                    </p>
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-medium text-gray-600">Status da Empresa</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $empresa->ativa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $empresa->ativa ? 'Ativa' : 'Inativa' }}
                    </span>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Quadras Cadastradas:</span>
                        <span class="font-medium">{{ $totalQuadras }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Quadras Ativas:</span>
                        <span class="font-medium">{{ $quadrasAtivas }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Clientes Ativos:</span>
                        <span class="font-medium">{{ $totalClientes }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RESERVAS RECENTES --}}
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Reservas Recentes</h3>
            <a href="{{ route('admin.reservas.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Ver todas
            </a>
        </div>
    </div>
    <div class="p-6">
        @if($reservasRecentes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quadra</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horário</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reservasRecentes as $reserva)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $reserva->cliente->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $reserva->cliente->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reserva->quadra->nome }}</div>
                                <div class="text-sm text-gray-500 capitalize">{{ $reserva->quadra->tipo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reserva->horario->horario_inicio }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-green-800">R$ {{ number_format($reserva->valor_total, 2, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pendente' => 'bg-yellow-100 text-yellow-800',
                                        'confirmado' => 'bg-green-100 text-green-800',
                                        'cancelado' => 'bg-red-100 text-red-800',
                                        'finalizado' => 'bg-blue-100 text-blue-800'
                                    ];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$reserva->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($reserva->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Nenhuma reserva recente.</p>
                <p class="text-gray-400 text-sm mt-1">As reservas aparecerão aqui quando forem criadas.</p>
            </div>
        @endif
    </div>
</div>
@endsection
