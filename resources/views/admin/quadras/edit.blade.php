@extends('layouts.admin')

@section('page-title', 'Editar: ' . $quadra->nome)

@section('admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Editar Quadra</h1>

        <a href="{{ route('admin.quadras.index') }}"
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


        <form action="{{ route('admin.quadras.update', $quadra) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="nome"
                       value="{{ old('nome', $quadra->nome) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Tipo</label>
                <select name="tipo"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    <option value="volei"    {{ old('tipo', $quadra->tipo) == 'volei' ? 'selected' : '' }}>Vôlei</option>
                    <option value="basquete" {{ old('tipo', $quadra->tipo) == 'basquete' ? 'selected' : '' }}>Basquete</option>
                    <option value="futsal"   {{ old('tipo', $quadra->tipo) == 'futsal' ? 'selected' : '' }}>Futsal</option>
                    <option value="society"  {{ old('tipo', $quadra->tipo) == 'society' ? 'selected' : '' }}>Society</option>
                    <option value="tenis"    {{ old('tipo', $quadra->tipo) == 'tenis' ? 'selected' : '' }}>Tênis</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Preço por Hora (R$)</label>
                <input type="number" step="0.01" name="preco_hora"
                       value="{{ old('preco_hora', $quadra->preco_hora) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Capacidade</label>
                <input type="number" name="capacidade"
                       value="{{ old('capacidade', $quadra->capacidade) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Status</label>
                <select name="disponivel"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    <option value="1" {{ old('disponivel', $quadra->disponivel) ? 'selected' : '' }}>Disponível</option>
                    <option value="0" {{ old('disponivel', $quadra->disponivel) ? '' : 'selected' }}>Indisponível</option>
                </select>
            </div>

            @if ($quadra->imagem)
                <div class="mb-4">
                    <label class="block font-medium text-gray-700 mb-1">Imagem Atual</label>
                    <img src="{{ asset('storage/' . $quadra->imagem) }}"
                         class="w-48 h-32 object-cover rounded border">
                </div>
            @endif

            <div class="mb-6">
                <label class="block font-medium text-gray-700 mb-1">Nova Imagem (opcional)</label>
                <input type="file" name="imagem"
                       class="w-full px-3 py-2 border border-gray-300 rounded bg-white">
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Atualizar
            </button>

        </form>

    </div>

</div>

@endsection
