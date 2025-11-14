@extends('layouts.admin')

@section('page-title', 'Cadastrar Quadra')

@section('admin-content')

<div class="p-6">

    {{-- Cabeçalho --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Cadastrar Quadra</h1>

        <a href="{{ route('admin.quadras.index') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            Voltar
        </a>
    </div>

    {{-- Formulário --}}
    <div class="bg-white shadow rounded p-6">

        <form action="{{ route('admin.quadras.store') }}" method="POST">
            @csrf

            {{-- Nome --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="nome"
                       value="{{ old('nome') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            {{-- Tipo --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Tipo</label>
                <select name="tipo"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    <option value="volei">Vôlei</option>
                    <option value="basquete">Basquete</option>
                    <option value="futsal">Futsal</option>
                    <option value="society">Society</option>
                    <option value="tenis">Tênis</option>
                </select>
            </div>

            {{-- Disponibilidade --}}
            <div class="mb-6">
                <label class="block font-medium text-gray-700 mb-1">Status</label>
                <select name="disponivel"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    <option value="1">Disponível</option>
                    <option value="0">Indisponível</option>
                </select>
            </div>

            <button
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Salvar
            </button>
        </form>

    </div>

</div>

@endsection
