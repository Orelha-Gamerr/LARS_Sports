@extends('layouts.admin')

@section('page-title', 'Editar: ' . $quadra->nome)

@section('admin-content')

<div class="p-6">

    {{-- Cabeçalho --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Editar Quadra</h1>

        <a href="{{ route('admin.quadras.index') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            Voltar
        </a>
    </div>

    {{-- Formulário --}}
    <div class="bg-white shadow rounded p-6">

        <form action="{{ route('admin.quadras.update', $quadra) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nome --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="nome"
                       value="{{ old('nome', $quadra->nome) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            {{-- Tipo --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Tipo</label>
                <select name="tipo"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    <option value="volei"     {{ $quadra->tipo == 'volei' ? 'selected' : '' }}>Vôlei</option>
                    <option value="basquete"  {{ $quadra->tipo == 'basquete' ? 'selected' : '' }}>Basquete</option>
                    <option value="futsal"    {{ $quadra->tipo == 'futsal' ? 'selected' : '' }}>Futsal</option>
                    <option value="society"   {{ $quadra->tipo == 'society' ? 'selected' : '' }}>Society</option>
                    <option value="tenis"     {{ $quadra->tipo == 'tenis' ? 'selected' : '' }}>Tênis</option>
                </select>
            </div>

            {{-- Disponibilidade --}}
            <div class="mb-6">
                <label class="block font-medium text-gray-700 mb-1">Status</label>
                <select name="disponivel"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    <option value="1" {{ $quadra->disponivel ? 'selected' : '' }}>Disponível</option>
                    <option value="0" {{ !$quadra->disponivel ? 'selected' : '' }}>Indisponível</option>
                </select>
            </div>

            <button
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Atualizar
            </button>
        </form>

    </div>

</div>

@endsection
