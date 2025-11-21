@extends('layouts.super-admin')

@section('page-title', 'Editar Empresas: ' . $empresa->nome)

@section('super-admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Cadastrar Empresa</h1>

        <a href="{{ route('super-admin.empresas.index') }}"
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

        <form action="{{ route('super-admin.empresas.update', $empresa) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="nome"
                       value="{{ old('nome', $empresa->nome) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">CNPJ</label>
                <input type="text" name="cnpj"
                       value="{{ old('cnpj', $empresa->cnpj) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Telefone</label>
                <input type="text" name="telefone"
                       value="{{ old('telefone', $empresa->telefone) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Email</label>
                <input type="text" name="email"
                       value="{{ old('email', $empresa->email) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Endereço</label>
                <input type="text" name="endereco"
                       value="{{ old('endereco', $empresa->endereco) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Responsável</label>
                <input type="text" name="responsavel"
                       value="{{ old('responsavel', $empresa->responsavel) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Status</label>
                <select name="ativa"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
                    <option value="1" {{ old('ativa', $empresa->ativa) ? 'selected' : '' }}>Ativa</option>
                    <option value="0" {{ old('ativa', $empresa->ativa) ? '' : 'selected' }}>Inativa</option>
                </select>
            </div>

            <button class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Salvar
            </button>

        </form>

    </div>

</div>

@endsection
