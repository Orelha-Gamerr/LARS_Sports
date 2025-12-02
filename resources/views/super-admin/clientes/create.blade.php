@extends('layouts.super-admin')

@section('page-title', 'Cadastrar Clientes')

@section('super-admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Cadastrar Clientes</h1>

        <a href="{{ route('super-admin.clientes.index') }}"
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

        <form action="{{ route('super-admin.clientes.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">CPF</label>
                <input type="text" name="cpf"
                       value="{{ old('cpf') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Telefone</label>
                <input type="text" name="telefone"
                       value="{{ old('telefone') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Email</label>
                <input type="text" name="email"
                       value="{{ old('email') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Endereço</label>
                <input type="text" name="endereco"
                       value="{{ old('endereco') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Senha</label>
                <input type="password" name="password"
                       value="{{ old('password') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Repetir Senha</label>
                <input type="password" name="password_confirmation"
                       value="{{ old('password') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-purple-200">
            </div>

            <button class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Salvar
            </button>

        </form>

    </div>

</div>

@endsection
