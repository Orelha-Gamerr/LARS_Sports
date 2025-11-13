@extends('layouts.super-admin')

@section('page-title', 'Dashboard Super Admin')

@section('super-admin-content')
<div class="mb-6 flex items-center space-x-4">
    <div class="p-3 bg-purple-100 rounded-lg">
        <i class="fas fa-crown text-2xl text-purple-600"></i>
    </div>
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Super Admin</h1>
        <p class="text-gray-600">Visão geral de todo o sistema</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-building text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Empresas Ativas</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $empresasAtivas }}</p>
                <p class="text-xs text-gray-500">de {{ $totalEmpresas }} total</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
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
                <p class="text-sm font-medium text-gray-600">Quadras no Sistema</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalQuadras }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Faturamento Total</p>
                <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Empresas Cadastradas</h3>
                <a href="{{ route('super-admin.empresas.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    Ver todas
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($empresas->count() > 0)
                <div class="space-y-4">
                    @foreach($empresas as $empresa)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-100 rounded">
                                <i class="fas fa-building text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $empresa->nome }}</h4>
                                <p class="text-sm text-gray-600">{{ $empresa->email }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs px-2 py-1 rounded-full {{ $empresa->ativa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $empresa->ativa ? 'Ativa' : 'Inativa' }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $empresa->quadras_count }} quadras</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('super-admin.empresas.show', $empresa) }}" class="text-purple-600 hover:text-purple-800">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-building text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Nenhuma empresa cadastrada.</p>
                    <a href="{{ route('super-admin.empresas.create') }}" class="inline-block mt-4 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Cadastrar Primeira Empresa
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Estatísticas do Sistema</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Reservas Totais</span>
                    <span class="font-semibold">{{ $totalReservas }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Reservas Confirmadas</span>
                    <span class="font-semibold text-green-600">{{ $reservasConfirmadas }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Reservas Pendentes</span>
                    <span class="font-semibold text-yellow-600">{{ $reservasPendentes }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Taxa de Confirmação</span>
                    <span class="font-semibold">{{ $taxaConfirmacao }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Faturamento Mensal</span>
                    <span class="font-semibold text-green-600">R$ {{ number_format($faturamentoMensal, 2, ',', '.') }}</span>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-2 gap-4">
                <a href="{{ route('super-admin.empresas.create') }}" class="bg-purple-600 text-white text-center py-2 px-4 rounded hover:bg-purple-700 transition">
                    Nova Empresa
                </a>
                <a href="{{ route('super-admin.relatorios.index') }}" class="bg-gray-600 text-white text-center py-2 px-4 rounded hover:bg-gray-700 transition">
                    Relatórios
                </a>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Reservas Recentes no Sistema</h3>
    </div>
    <div class="p-6">
        @if($reservasRecentes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quadra</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reservasRecentes as $reserva)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $reserva->cliente->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reserva->quadra->nome }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reserva->quadra->empresa->nome }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $reserva->horario->horario_inicio }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                R$ {{ number_format($reserva->valor_total, 2, ',', '.') }}
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
            <p class="text-gray-500 text-center py-4">Nenhuma reserva recente.</p>
        @endif
    </div>
</div>
@endsection