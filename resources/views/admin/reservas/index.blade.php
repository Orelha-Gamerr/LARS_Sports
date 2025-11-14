@extends('layouts.admin')

@section('title', 'Reservas - Admin')

@section('page-title', 'Gerenciar Reservas')
@section('page-subtitle', 'Acompanhe, edite ou cancele reservas realizadas')

@section('admin-content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-700">Listagem de Reservas</h2>

        <a href="{{ route('admin.reservas.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Nova Reserva
        </a>
    </div>

    {{-- 🔍 SEARCHBAR --}}
    <form method="GET" action="{{ route('admin.reservas.search') }}" class="mb-6">
        <div class="flex gap-3">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Buscar por cliente ou quadra..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
            >

            <button class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    @if($reservas->count() > 0)

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-3 text-left font-semibold">#</th>
                        <th class="px-4 py-3 text-left font-semibold">Quadra</th>
                        <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                        <th class="px-4 py-3 text-left font-semibold">Data</th>
                        <th class="px-4 py-3 text-left font-semibold">Horário</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-center font-semibold">Ações</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach($reservas as $reserva)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $reserva->id }}</td>

                        <td class="px-4 py-3">{{ $reserva->quadra->nome ?? '—' }}</td>

                        <td class="px-4 py-3">{{ $reserva->cliente->user->name ?? '—' }}</td>

                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $reserva->horario->horario_inicio ?? '—' }}
                        </td>

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

                        <td class="px-4 py-3 text-center text-lg flex items-center justify-center gap-4">

                            <a href="{{ route('admin.reservas.show', $reserva->id) }}"
                                class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.reservas.edit', $reserva->id) }}"
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.reservas.destroy', $reserva->id) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Deseja excluir esta reserva?')"
                                        class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="mt-6">
            {{ $reservas->appends(request()->query())->links() }}
        </div>

    @else
        <div class="bg-yellow-50 p-6 rounded-lg border-l-4 border-yellow-400">
            <p class="text-yellow-700 font-medium">Nenhuma reserva encontrada.</p>
        </div>
    @endif

</div>

@endsection
