@extends('layouts.admin')

@section('page-title', 'Quadras')

@section('admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Quadras</h1>

        <a href="{{ route('admin.quadras.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Nova Quadra
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse text-left">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 font-medium text-gray-700 w-24">Imagem</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Nome</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Tipo</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Status</th>
                    <th class="px-4 py-3 font-medium text-gray-700 w-40">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($quadras as $quadra)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3">
                            @if($quadra->imagem)
                                <img src="{{ asset('storage/' . $quadra->imagem) }}"
                                     class="w-16 h-12 object-cover rounded border">
                            @else
                                <span class="text-gray-400 text-sm">Sem imagem</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">{{ $quadra->nome }}</td>
                        <td class="px-4 py-3 capitalize">{{ $quadra->tipo }}</td>

                        <td class="px-4 py-3">
                            @if($quadra->disponivel)
                                <span class="px-2 py-1 text-sm bg-green-100 text-green-800 rounded-full">Disponível</span>
                            @else
                                <span class="px-2 py-1 text-sm bg-red-100 text-red-800 rounded-full">Indisponível</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3 text-lg">

                                <a href="{{ route('admin.quadras.show', $quadra) }}"
                                   class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.quadras.edit', $quadra) }}"
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.quadras.destroy', $quadra) }}" method="POST"
                                      onsubmit="return confirm('Deseja excluir esta quadra?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">
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
        {{ $quadras->links() }}
    </div>

</div>

@endsection
