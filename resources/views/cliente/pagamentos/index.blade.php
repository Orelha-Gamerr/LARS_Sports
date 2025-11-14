@extends('layouts.cliente-app')

@section('title', 'Meus Pagamentos - Reserve Quadras')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-green-800">Meus Pagamentos</h1>
    <p class="text-gray-600 mt-2">Acompanhe o histórico de seus pagamentos</p>
</div>

<!-- Filtros -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex flex-wrap gap-4">
        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <option value="">Todos os status</option>
            <option value="pendente">Pendente</option>
            <option value="pago">Pago</option>
            <option value="cancelado">Cancelado</option>
        </select>
        <input type="month" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-medium">
            Filtrar
        </button>
    </div>
</div>

<!-- Lista de Pagamentos -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-bold text-green-800">Histórico de Pagamentos</h3>
    </div>
    <div class="p-6">
        @if($pagamentos->count() > 0)
            <div class="space-y-4">
                @foreach($pagamentos as $pagamento)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-money-bill-wave text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Reserva #{{ $pagamento->reserva->codigo_reserva }}</h4>
                            <p class="text-sm text-gray-600">{{ $pagamento->reserva->quadra->nome }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($pagamento->created_at)->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="font-bold text-green-800">R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</p>
                            @php
                                $statusColors = [
                                    'pendente' => 'bg-yellow-100 text-yellow-800',
                                    'pago' => 'bg-green-100 text-green-800',
                                    'cancelado' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="text-xs px-2 py-1 rounded-full {{ $statusColors[$pagamento->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($pagamento->status) }}
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('cliente.pagamentos.show', $pagamento) }}" class="p-2 text-green-600 hover:text-green-800 transition" title="Ver detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $pagamentos->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <div class="p-4 bg-green-50 rounded-lg inline-block mb-4">
                    <i class="fas fa-receipt text-4xl text-green-600"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Nenhum pagamento encontrado</h4>
                <p class="text-gray-600 mb-4">Você ainda não possui pagamentos registrados.</p>
            </div>
        @endif
    </div>
</div>
@endsection