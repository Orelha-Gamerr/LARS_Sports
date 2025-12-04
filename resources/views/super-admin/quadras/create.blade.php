@extends('layouts.super-admin')

@section('page-title', 'Cadastrar Quadras')

@section('super-admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Cadastrar Quadras</h1>

        <a href="{{ route('super-admin.quadras.index') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            Voltar
        </a>
    </div>

    <div class="bg-white shadow rounded p-6">

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('super-admin.quadras.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 mt-4">Empresa</label>
                <select name="empresa_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Selecione uma Empresa</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}"
                            {{ $empresa->id == $empresa->empresa_id ? 'selected' : '' }}>
                            {{ $empresa->nome ?? $empresa->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4 mt-4">
                <label class="block font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="nome"
                       value="{{ old('nome') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Tipo</label>
                <select name="tipo"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    <option value="volei"    {{ old('tipo') == 'volei' ? 'selected' : '' }}>Vôlei</option>
                    <option value="basquete" {{ old('tipo') == 'basquete' ? 'selected' : '' }}>Basquete</option>
                    <option value="futsal"   {{ old('tipo') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                    <option value="society"  {{ old('tipo') == 'society' ? 'selected' : '' }}>Society</option>
                    <option value="tenis"    {{ old('tipo') == 'tenis' ? 'selected' : '' }}>Tênis</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Capacidade</label>
                <input type="number" name="capacidade"
                       value="{{ old('capacidade') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Preço Hora</label>
                <input type="number" name="preco_hora" step="0.01"
                       value="{{ old('preco_hora') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <!-- Campo de Imagem -->
            <div>
                <label for="imagem" class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <input id="imagem" name="imagem" type="file" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            accept="image/*"
                            onchange="previewFoto(this)">
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF até 2MB</p>
                    </div>
                </div>
                @error('imagem')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 mt-3">
                <label class="block font-medium text-gray-700 mb-1">Disponibilidade</label>
                <select name="disponivel"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
                    <option value="1" {{ old('ativa') == '1' ? 'selected' : '' }}>Ativa</option>
                    <option value="0" {{ old('ativa') == '0' ? 'selected' : '' }}>Inativa</option>
                </select>
            </div>

            <button class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Salvar
            </button>

        </form>

    </div>

</div>

@endsection
