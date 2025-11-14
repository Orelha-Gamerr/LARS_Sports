@extends('layouts.cliente-app')

@section('title', 'Quadras Disponíveis - Reserve Quadras')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-green-800">Quadras Disponíveis</h1>
    <p class="text-gray-600 mt-2">Encontre a quadra perfeita para sua partida</p>
</div>

<!-- Filtros e Busca -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <form action="{{ route('cliente.quadras.search') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Localização</label>
                <input type="text" name="localizacao" placeholder="Digite o endereço..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                <select name="modalidade" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Todos</option>
                    <option value="society">Society</option>
                    <option value="futsal">Futsal</option>
                    <option value="volei">Vôlei</option>
                    <option value="basquete">Basquete</option>
                    <option value="tenis">Tênis</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                <select name="ordenar" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="nome">Nome</option>
                    <option value="preco">Menor Preço</option>
                    <option value="capacidade">Maior Capacidade</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-medium">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Lista de Quadras -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($quadras as $quadra)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-all duration-300">
        <div class="h-48 bg-gradient-to-r from-green-400 to-green-600 relative">
            @if($quadra->imagem)
                <img src="{{ asset('storage/' . $quadra->imagem) }}" alt="{{ $quadra->nome }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fas fa-futbol text-white text-6xl"></i>
                </div>
            @endif
            <div class="absolute top-3 right-3">
                <span class="bg-white text-green-800 text-xs font-bold px-2 py-1 rounded-full">
                    ⭐ 4.5
                </span>
            </div>
            <div class="absolute bottom-3 left-3">
                <span class="bg-green-600 text-white text-xs font-medium px-2 py-1 rounded">
                    R$ {{ number_format($quadra->preco_hora, 2, ',', '.') }}/hora
                </span>
            </div>
        </div>
        <div class="p-4">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-bold text-gray-800 text-lg">{{ $quadra->nome }}</h3>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded capitalize">{{ $quadra->tipo }}</span>
            </div>
            
            <!-- Nome da Empresa -->
            <div class="mb-3">
                <p class="text-sm text-gray-700 flex items-center">
                    <i class="fas fa-building text-green-500 mr-2"></i>
                    <strong>{{ $quadra->empresa->nome }}</strong>
                </p>
            </div>
            
            <p class="text-gray-600 text-sm mb-3 flex items-center">
                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                {{ $quadra->empresa->endereco }}
            </p>
            
            @if($quadra->descricao)
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                {{ Str::limit($quadra->descricao, 100) }}
            </p>
            @endif
            
            <div class="flex justify-between items-center">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-users mr-1"></i>
                    {{ $quadra->capacidade }} pessoas
                </div>
                <a href="{{ route('cliente.quadras.show', $quadra) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition font-medium">
                    Ver Detalhes
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <div class="p-4 bg-green-50 rounded-lg inline-block mb-4">
            <i class="fas fa-futbol text-4xl text-green-600"></i>
        </div>
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Nenhuma quadra encontrada</h4>
        <p class="text-gray-600 mb-4">Tente ajustar os filtros para ver mais resultados.</p>
        <a href="{{ route('cliente.quadras.index') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition inline-flex items-center">
            <i class="fas fa-sync-alt mr-2"></i>
            Limpar Filtros
        </a>
    </div>
    @endforelse
</div>

@if($quadras->hasPages())
<div class="mt-6">
    {{ $quadras->links() }}
</div>
@endif

<!-- Estatísticas -->
<div class="mt-8 bg-green-50 rounded-xl p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
        <div>
            <p class="text-2xl font-bold text-green-800">{{ $quadras->total() }}</p>
            <p class="text-gray-600">Quadras Disponíveis</p>
        </div>
        <div>
            <p class="text-2xl font-bold text-green-800">{{ $quadras->unique('empresa_id')->count() }}</p>
            <p class="text-gray-600">Empresas Parceiras</p>
        </div>
        <div>
            <p class="text-2xl font-bold text-green-800">{{ $quadras->count() }}</p>
            <p class="text-gray-600">Tipos Diferentes</p>
        </div>
    </div>
</div>
@endsection