@extends('layouts.cliente-app')

@section('title', 'Minhas Reservas - Reserve Quadras')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-green-800">Minhas Reservas</h1>
    <p class="text-gray-600 mt-2">Acompanhe todas as suas reservas de quadras</p>
</div>

<!-- Filtros -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex flex-wrap gap-4">
        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <option value="">Todos os status</option>
            <option value="pendente">Pendente</option>
            <option value="confirmado">Confirmado</option>
            <option value="cancelado">Cancelado</option>
            <option value="finalizado">Finalizado</option>
        </select>
        <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-medium">
            Filtrar
        </button>
    </div>
</div>

<!-- Lista de Reservas -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-bold text-green-800">Histórico de Reservas</h3>
    </div>
    <div class="p-6">
        @if($reservas->count() > 0)
            <div class="space-y-4">
                @foreach($reservas as $reserva)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-futbol text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $reserva->quadra->nome }}</h4>
                            <p class="text-sm text-gray-600">{{ $reserva->quadra->empresa->nome }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }} às {{ $reserva->horario->horario_inicio }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="font-bold text-green-800">R$ {{ number_format($reserva->valor_total, 2, ',', '.') }}</p>
                            @php
                                $statusColors = [
                                    'pendente' => 'bg-yellow-100 text-yellow-800',
                                    'confirmado' => 'bg-green-100 text-green-800',
                                    'cancelado' => 'bg-red-100 text-red-800',
                                    'finalizado' => 'bg-blue-100 text-blue-800'
                                ];
                            @endphp
                            <span class="text-xs px-2 py-1 rounded-full {{ $statusColors[$reserva->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($reserva->status) }}
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('cliente.reservas.show', $reserva) }}" class="p-2 text-green-600 hover:text-green-800 transition" title="Ver detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($reserva->status == 'pendente')
                            <a href="{{ route('cliente.reservas.edit', $reserva) }}" class="p-2 text-blue-600 hover:text-blue-800 transition" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('cliente.reservas.destroy', $reserva) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:text-red-800 transition" title="Cancelar" onclick="return confirm('Tem certeza que deseja cancelar esta reserva?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $reservas->links() }}
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