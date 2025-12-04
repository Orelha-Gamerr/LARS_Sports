@extends('layouts.super-admin')

@section('page-title', 'Quadras')

@section('super-admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Quadras</h1>

        <a href="{{ route('super-admin.quadras.create') }}"
           class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Nova Quadra
        </a>
    </div>
    <form action="{{ route('super-admin.quadras.search') }}" method="GET" class="mb-6">
        <div class="flex items-center gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nome ou empresa..."
                class="w-64 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-600"
            >

            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>

            @if(request('search'))
                <a href="{{ route('super-admin.quadras.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Limpar
                </a>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse text-left">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 font-medium text-gray-700">Empresa</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Nome</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Tipo</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Capacidade</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Imagem</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Disponibilidade</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($quadras as $quadra)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3 whitespace-nowrap">{{ $quadra->empresa->nome }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $quadra->nome }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $quadra->tipo }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $quadra->capacidade }}</td>
                    <td class="px-4 py-3">
                        @if($quadra->imagem)
                            <img src="{{ asset('storage/' . $quadra->imagem) }}"
                                class="w-16 h-12 object-cover rounded border">
                        @else
                            <span class="text-gray-400 text-sm">Sem imagem</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($quadra->disponivel == true)
                            <span class="px-2 py-1 text-sm bg-green-100 text-green-800 rounded-full">Ativa</span>
                        @else
                            <span class="px-2 py-1 text-sm bg-red-100 text-red-800 rounded-full">Inativa</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-3 text-lg">
                            <a href="{{ route('super-admin.quadras.show', $quadra) }}"
                            class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('super-admin.quadras.edit', $quadra) }}"
                            class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('super-admin.quadras.destroy', $quadra) }}" method="POST"
                                onsubmit="return confirm('Deseja excluir esta quadra?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-6">
        {{ $quadras->links() }}
    </div>

</div>

@endsection
