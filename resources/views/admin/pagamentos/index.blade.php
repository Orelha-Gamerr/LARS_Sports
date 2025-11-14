@extends('layouts.admin')

@section('page-title', 'Pagamentos')

@section('admin-content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Listagem de Pagamentos</h1>
            <p class="text-sm text-gray-500">Pagamentos vinculados às reservas da empresa</p>
        </div>

        <a href="{{ route('admin.pagamentos.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Novo Pagamento
        </a>
    </div>

    <form action="{{ route('admin.pagamentos.search') }}" method="POST" class="mb-6">
        @csrf
        <div class="flex items-center gap-3">
            <input type="text" name="search" placeholder="Buscar por cliente ou código..."
                value="{{ old('search') }}"
                class="w-96 px-3 py-2 border border-gray-300 rounded">

            <button class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800 flex items-center gap-2">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 font-medium text-gray-700">Cliente</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Quadra</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Valor</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Método</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Status</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Código</th>
                    <th class="px-4 py-3 font-medium text-gray-700 w-32">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pagamentos as $pagamento)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3">
                        {{ $pagamento->reserva->cliente->user->name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $pagamento->reserva->quadra->nome }}
                    </td>

                    <td class="px-4 py-3">
                        R$ {{ number_format($pagamento->valor, 2, ',', '.') }}
                    </td>

                    <td class="px-4 py-3 capitalize">
                        {{ str_replace('_', ' ', $pagamento->metodo) }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded text-white text-sm
                            @switch($pagamento->status)
                                @case('pago') bg-green-600 @break
                                @case('pendente') bg-yellow-600 @break
                                @case('cancelado') bg-red-600 @break
                                @case('estornado') bg-purple-600 @break
                            @endswitch
                        ">
                            {{ ucfirst($pagamento->status) }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        {{ $pagamento->codigo_transacao ?? '—' }}
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex items-center gap-4 text-lg">

                            <a href="{{ route('admin.pagamentos.show', $pagamento) }}"
                               class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.pagamentos.edit', $pagamento) }}"
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.pagamentos.destroy', $pagamento) }}"
                                  method="POST"
                                  onsubmit="return confirm('Excluir este pagamento?')"
                                  class="inline">
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
        {{ $pagamentos->links() }}
    </div>

</div>
@endsection
