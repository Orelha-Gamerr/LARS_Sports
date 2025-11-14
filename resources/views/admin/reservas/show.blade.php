@extends('layouts.admin')

@section('page-title', 'Reserva #' . $reserva->id)

@section('admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Detalhes da Reserva</h1>

        <a href="{{ route('admin.reservas.index') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            Voltar
        </a>
    </div>

    <div class="bg-white shadow rounded p-6">

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-gray-700">Cliente</h2>
            <p class="text-gray-900">
                {{ $reserva->cliente->nome ?? '—' }}
            </p>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-gray-700">Quadra</h2>
            <p class="text-gray-900">
                {{ $reserva->quadra->nome ?? '—' }}
            </p>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-gray-700">Data da Reserva</h2>
            <p class="text-gray-900">
                {{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}
            </p>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-gray-700">Horário</h2>
            @if($reserva->horario)
                <p class="text-gray-900">
                    {{ $reserva->horario->horario_inicio }} — {{ $reserva->horario->horario_fim }}
                </p>
            @else
                <p class="text-gray-500">—</p>
            @endif
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-gray-700">Status</h2>

            @php
                $statusColors = [
                    'pendente' => 'bg-yellow-200 text-yellow-800',
                    'confirmado' => 'bg-green-200 text-green-800',
                    'cancelado' => 'bg-red-200 text-red-800',
                    'finalizado' => 'bg-blue-200 text-blue-800',
                ];
            @endphp

            <span class="px-3 py-1 rounded text-sm font-semibold 
                {{ $statusColors[$reserva->status] ?? 'bg-gray-200 text-gray-800' }}">
                {{ ucfirst($reserva->status) }}
            </span>
        </div>

        <div class="mt-6 flex gap-3">

            <a href="{{ route('admin.reservas.edit', $reserva->id) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Editar
            </a>

            <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" 
                  method="POST"
                  onsubmit="return confirm('Excluir esta reserva?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Excluir
                </button>
            </form>

        </div>

    </div>

</div>

@endsection
