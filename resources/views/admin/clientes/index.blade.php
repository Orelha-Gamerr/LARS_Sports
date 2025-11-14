@extends('layouts.admin')

@section('page-title', 'Clientes')

@section('admin-content')
<div class="p-6">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold">Listagem de Clientes</h1>
        <p class="text-sm text-gray-500">Clientes que fizeram reservas nessa empresa</p>
    </div>

    <form action="{{ route('admin.clientes.search') }}" method="POST" class="mb-6">
        @csrf
        <div class="flex items-center gap-3">
            <input type="text" name="search" placeholder="Buscar cliente por nome, e-mail ou CPF..."
                   class="w-96 px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200"
                   value="{{ old('search') }}">

            <button class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800 flex items-center gap-2">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 font-medium text-gray-700">#</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Nome</th>
                    <th class="px-4 py-3 font-medium text-gray-700">E-mail</th>
                    <th class="px-4 py-3 font-medium text-gray-700">CPF</th>
                    <th class="px-4 py-3 font-medium text-gray-700 w-20">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($clientes as $cliente)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $cliente->id }}</td>
                        <td class="px-4 py-3">{{ $cliente->user->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $cliente->user->email ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $cliente->cpf ?? '—' }}</td>

                        <td class="px-4 py-3">
                            <div class="flex items-center gap-4 text-lg">

                                <a href="{{ route('admin.clientes.show', $cliente) }}"
                                   class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-eye"></i>
                                </a>

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
