@extends('layouts.cliente-app')

@section('title', 'Nova Reserva - Reserve Quadras')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-green-800">Nova Reserva</h1>
    <p class="text-gray-600 mt-2">Preencha os dados para fazer uma nova reserva</p>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-green-800">Dados da Reserva</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('cliente.reservas.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quadra</label>
                        <select name="quadra_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                            <option value="">Selecione uma quadra</option>
                            @foreach($quadras as $quadra)
                            <option value="{{ $quadra->id }}">{{ $quadra->nome }} - R$ {{ number_format($quadra->preco_hora, 2, ',', '.') }}/hora</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data da Reserva</label>
                        <input type="date" name="data_reserva" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Horário</label>
                        <select name="horario_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                            <option value="">Selecione um horário</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observações (Opcional)</label>
                        <textarea name="observacoes" rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                  placeholder="Alguma observação especial..."></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition">
                            Confirmar Reserva
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection