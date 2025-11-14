@extends('layouts.cliente-app')

@section('title', 'Editar Reserva - Reserve Quadras')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-green-800">Editar Reserva</h1>
    <p class="text-gray-600 mt-2">Atualize os dados da sua reserva</p>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-green-800">Editar Reserva</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('cliente.reservas.update', $reserva) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quadra</label>
                        <p class="text-gray-900 font-semibold">{{ $reserva->quadra->nome }}</p>
                        <p class="text-sm text-gray-600">R$ {{ number_format($reserva->quadra->preco_hora, 2, ',', '.') }}/hora</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data da Reserva</label>
                        <input type="date" name="data_reserva" value="{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('Y-m-d') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Horário</label>
                        <select name="horario_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                            <option value="">Selecione um horário</option>
                            @foreach($horarios as $horario)
                            <option value="{{ $horario->id }}" {{ $reserva->horario_id == $horario->id ? 'selected' : '' }}>
                                {{ $horario->horario_inicio }} - {{ $horario->horario_fim }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observações (Opcional)</label>
                        <textarea name="observacoes" rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                  placeholder="Alguma observação especial...">{{ $reserva->observacoes }}</textarea>
                    </div>

                    <div class="pt-4 flex space-x-4">
                        <button type="submit" class="flex-1 bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition">
                            Atualizar Reserva
                        </button>
                        <a href="{{ route('cliente.reservas.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-bold hover:bg-gray-400 transition text-center">
                            Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection