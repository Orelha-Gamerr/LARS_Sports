@extends('layouts.admin')

@section('page-title', 'Quadra: ' . $quadra->nome)

@section('admin-content')

<div class="p-6">

    {{-- Cabeçalho --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Detalhes da Quadra</h1>

        <a href="{{ route('admin.quadras.index') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            Voltar
        </a>
    </div>

    {{-- Conteúdo --}}
    <div class="bg-white shadow rounded p-6">

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-gray-700">Nome</h2>
            <p class="text-gray-900">{{ $quadra->nome }}</p>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-gray-700">Tipo</h2>
            <p class="text-gray-900 capitalize">{{ $quadra->tipo }}</p>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-gray-700">Status</h2>
            @if($quadra->disponivel)
                <span class="px-3 py-1 text-sm bg-green-200 text-green-800 rounded">Disponível</span>
            @else
                <span class="px-3 py-1 text-sm bg-red-200 text-red-800 rounded">Indisponível</span>
            @endif
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.quadras.edit', $quadra) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Editar
            </a>

            <form action="{{ route('admin.quadras.destroy', $quadra) }}" method="POST"
                  onsubmit="return confirm('Excluir esta quadra?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Excluir
                </button>
            </form>
        </div>

    </div>

</div>

@endsection
