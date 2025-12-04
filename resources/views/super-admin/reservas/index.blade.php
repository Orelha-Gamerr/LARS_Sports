@extends('layouts.super-admin')

@section('page-title', 'Reservas')

@section('super-admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Reservas</h1>

    </div>
    <form action="{{ route('super-admin.reservas.search') }}" method="GET" class="mb-6">
        <div class="flex items-center gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por cliente ou empresa..."
                class="w-64 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-600"
            >

            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>

            @if(request('search'))
                <a href="{{ route('super-admin.reservas.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Limpar
                </a>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse text-left">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Quadra</th>
                    <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                    <th class="px-4 py-3 text-left font-semibold">Data</th>
                    <th class="px-4 py-3 text-left font-semibold">Horário</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-center font-semibold">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservas as $reserva)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3 whitespace-nowrap">{{ $reserva->quadra->nome }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $reserva->cliente->user->name }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $reserva->horario->horario_inicio ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @php
                            $statusColors = [
                                'pendente' => 'bg-yellow-100 text-yellow-800',
                                'confirmado' => 'bg-green-100 text-green-800',
                                'cancelado' => 'bg-red-100 text-red-800',
                                'finalizado' => 'bg-blue-100 text-blue-800',
                            ];
                        @endphp

                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            {{ $statusColors[$reserva->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($reserva->status) }}
                        </span>
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-3 text-lg">
                            <a href="{{ route('super-admin.reservas.show', $reserva) }}"
                            class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('super-admin.reservas.edit', $reserva) }}"
                            class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('super-admin.reservas.destroy', $reserva) }}" method="POST"
                                onsubmit="return confirm('Deseja excluir esta Reserva?')">
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
        {{ $reservas->links() }}
    </div>

</div>

@endsection
