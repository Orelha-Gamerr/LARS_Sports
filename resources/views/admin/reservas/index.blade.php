@extends('layouts.admin')

@section('title', 'Gerenciar Reservas')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Gerenciar Reservas</h1>

    @if($reservas->count() > 0)
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Quadra</th>
                        <th class="px-4 py-2 border">Cliente</th>
                        <th class="px-4 py-2 border">Data</th>
                        <th class="px-4 py-2 border">Horário</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $reserva)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $reserva->id }}</td>
                            <td class="px-4 py-2 border">{{ $reserva->quadra->nome ?? '—' }}</td>
                            <td class="px-4 py-2 border">{{ $reserva->cliente->nome ?? '—' }}</td>
                            <td class="px-4 py-2 border">{{ $reserva->data ?? '—' }}</td>
                            <td class="px-4 py-2 border">{{ $reserva->horario ?? '—' }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 text-sm rounded 
                                    {{ $reserva->status == 'confirmada' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ ucfirst($reserva->status ?? 'Pendente') }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('admin.reservas.show', $reserva->id) }}" class="text-blue-600 hover:underline">Ver</a> |
                                <a href="{{ route('admin.reservas.edit', $reserva->id) }}" class="text-yellow-600 hover:underline">Editar</a> |
                                <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Deseja excluir esta reserva?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $reservas->links() }}
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded">
            <p>Nenhuma reserva encontrada.</p>
        </div>
    @endif
</div>
@endsection
