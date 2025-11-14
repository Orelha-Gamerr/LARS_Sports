@extends('layouts.cliente-app')

@section('title', 'Meu Perfil - Reserve Quadras')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-green-800">Meu Perfil</h1>
        <p class="text-gray-600 mt-2">Gerencie suas informações pessoais</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-green-800">Informações Pessoais</h3>
        </div>
        
        <div class="p-6">
            <!-- Foto -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                <div class="flex items-center space-x-4">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                        @if($cliente->foto)
                            <img src="{{ asset('storage/' . $cliente->foto) }}" alt="Foto do perfil" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user text-gray-400 text-3xl"></i>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                    <p class="text-gray-900 font-semibold">{{ auth()->user()->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                    <p class="text-gray-900 font-semibold">{{ auth()->user()->email }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                    <p class="text-gray-900 font-semibold">{{ $cliente->telefone ?? 'Não informado' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CPF</label>
                    <p class="text-gray-900 font-semibold">{{ $cliente->cpf ?? 'Não informado' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data de Nascimento</label>
                    <p class="text-gray-900 font-semibold">
                        {{ $cliente->data_nascimento ? $cliente->data_nascimento->format('d/m/Y') : 'Não informada' }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Endereço</label>
                    <p class="text-gray-900 font-semibold">{{ $cliente->endereco ?? 'Não informado' }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data de Cadastro</label>
                    <p class="text-gray-900 font-semibold">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            
            <div class="mt-8 flex space-x-4">
                <a href="{{ route('cliente.perfil.edit') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition">
                    <i class="fas fa-edit mr-2"></i>Editar Perfil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection