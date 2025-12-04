@extends('layouts.super-admin')

@section('page-title', 'Editar Reserva: ' . $reserva->cliente->user->name)

@section('super-admin-content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Editar Reserva</h1>

        <a href="{{ route('super-admin.reservas.index') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            Voltar
        </a>
    </div>

    <div class="bg-white shadow rounded p-6">

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('super-admin.reservas.update', $reserva) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quadra</label>
                <select name="quadra_id" id="quadra_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Selecione uma quadra</option>
                    @foreach($quadras as $quadra)
                        <option value="{{ $quadra->id }}" 
                            {{ $quadra->id == $reserva->quadra_id ? 'selected' : '' }}
                            data-preco="{{ $quadra->preco_hora }}">
                            {{ $quadra->nome }} - R$ {{ number_format($quadra->preco_hora, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 mt-4">Cliente</label>
                <select name="cliente_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}"
                            {{ $cliente->id == $reserva->cliente_id ? 'selected' : '' }}>
                            {{ $cliente->user->name ?? $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data da Reserva *</label>
                <input type="date" name="data_reserva"
                    value="{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('Y-m-d') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Horário *</label>
                <select name="horario_id" id="horario_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Carregando horários...</option>
                    @foreach($horarios as $h)
                        <option value="{{ $h->id }}"
                            {{ $h->id == $reserva->horario_id ? 'selected' : '' }}>
                            {{ $h->horario_inicio }}@if($h->horario_fim) - {{ $h->horario_fim }}@endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Valor *</label>
                <input type="number" step="0.01" name="valor_total"
                    value="{{ $reserva->valor_total }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 mt-4">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="pendente"    {{ $reserva->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="confirmado"  {{ $reserva->status == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="cancelado"   {{ $reserva->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="finalizado"  {{ $reserva->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                </select>
            </div>

            <button class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 mt-4">
                Salvar
            </button>

        </form>

    </div>

</div>

@endsection
