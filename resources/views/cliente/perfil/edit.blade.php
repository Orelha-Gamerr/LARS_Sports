@extends('layouts.cliente-app')

@section('title', 'Editar Perfil - Reserve Quadras')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-green-800">Editar Perfil</h1>
        <p class="text-gray-600 mt-2">Atualize suas informações pessoais</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-green-800">Informações Pessoais</h3>
        </div>
        
        <div class="p-6">
            <form action="{{ route('cliente.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                        <input type="text" name="telefone" value="{{ old('telefone', auth()->user()->telefone) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="(11) 99999-9999">
                        @error('telefone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-8 flex space-x-4">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition">
                        <i class="fas fa-save mr-2"></i>Salvar Alterações
                    </button>
                    <a href="{{ route('cliente.perfil.show') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-400 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection