@extends('layouts.super-admin')

@section('page-title', 'Empresas')

@section('super-admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Empresas</h1>

        <a href="{{ route('super-admin.empresas.create') }}"
           class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Nova Empresa
        </a>
    </div>
    <form action="{{ route('super-admin.empresas.search') }}" method="GET" class="mb-6">
        <div class="flex items-center gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nome ou cidade..."
                class="w-64 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-600"
            >

            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>

            @if(request('search'))
                <a href="{{ route('super-admin.empresa.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
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
                    <th class="px-4 py-3 font-medium text-gray-700">CNPJ</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Telefone</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Email</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Endereço</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Responsável</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Ativa</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($empresas as $empresa)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3 whitespace-nowrap">{{ $empresa->nome }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $empresa->cnpj }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $empresa->telefone }}</td>
                    <td class="px-4 py-3 truncate max-w-xs">{{ $empresa->email }}</td>
                    <td class="px-4 py-3 min-w-[200px]">{{ $empresa->endereco }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $empresa->responsavel }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($empresa->ativa == true)
                            <span class="px-2 py-1 text-sm bg-green-100 text-green-800 rounded-full">Ativa</span>
                        @else
                            <span class="px-2 py-1 text-sm bg-red-100 text-red-800 rounded-full">Inativa</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-3 text-lg">
                            <a href="{{ route('super-admin.empresas.show', $empresa) }}"
                            class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('super-admin.empresas.edit', $empresa) }}"
                            class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('super-admin.empresas.destroy', $empresa) }}" method="POST"
                                onsubmit="return confirm('Deseja excluir esta empresa?')">
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
        {{ $empresas->links() }}
    </div>

</div>

@endsection
