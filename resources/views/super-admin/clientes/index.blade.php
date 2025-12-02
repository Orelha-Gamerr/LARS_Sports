@extends('layouts.super-admin')

@section('page-title', 'Clientes')

@section('super-admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Clientes</h1>

        <a href="{{ route('super-admin.clientes.create') }}"
           class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Novo Cliente
        </a>
    </div>
    <form action="{{ route('super-admin.clientes.search') }}" method="GET" class="mb-6">
        <div class="flex items-center gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nome..."
                class="w-64 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-600"
            >

            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>

            @if(request('search'))
                <a href="{{ route('super-admin.clientes.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Limpar
                </a>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse text-left">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 font-medium text-gray-700">Nome</th>
                    <th class="px-4 py-3 font-medium text-gray-700">CPF</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Telefone</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Email</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Data Nascimento</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Endereço</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($clientes as $cliente)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3 whitespace-nowrap">{{ $cliente->nome }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $cliente->cpf }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $cliente->telefone }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $cliente->email }}</td>
                    <td class="px-4 py-3 truncate max-w-xs">{{ $cliente->data_nascimento }}</td>
                    <td class="px-4 py-3 min-w-[200px]">{{ $cliente->endereco }}</td>
                    
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-3 text-lg">
                            <a href="{{ route('super-admin.clientes.show', $cliente) }}"
                            class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('super-admin.clientes.edit', $cliente) }}"
                            class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('super-admin.clientes.destroy', $cliente) }}" method="POST"
                                onsubmit="return confirm('Deseja excluir este cliente?')">
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
        {{ $clientes->links() }}
    </div>

</div>

@endsection
