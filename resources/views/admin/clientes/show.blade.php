@extends('layouts.admin')

@section('page-title', 'Cliente: ' . ($cliente->user->name ?? 'Detalhes'))

@section('admin-content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Detalhes do Cliente</h1>
            <p class="text-sm text-gray-500">Informações básicas e histórico</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.clientes.index') }}"
               class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                Voltar
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-600">Nome</h3>
                <p class="text-gray-900">{{ $cliente->user->name ?? '—' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-600">E-mail</h3>
                <p class="text-gray-900">{{ $cliente->user->email ?? '—' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-600">Telefone</h3>
                <p class="text-gray-900">{{ $cliente->telefone ?? '—' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-600">CPF</h3>
                <p class="text-gray-900">{{ $cliente->cpf ?? '—' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-600">Data de Nascimento</h3>
                <p class="text-gray-900">
                    {{ $cliente->data_nascimento ? \Carbon\Carbon::parse($cliente->data_nascimento)->format('d/m/Y') : '—' }}
                </p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-600">Endereço</h3>
                <p class="text-gray-900">{{ $cliente->endereco ?? '—' }}</p>
            </div>
        </div>

        @if($cliente->reservas && $cliente->reservas->count() > 0)
            <div class="mt-6">
                <h4 class="text-lg font-semibold mb-3">Reservas (Últimas)</h4>
                <div class="space-y-3">
                    @foreach($cliente->reservas()->latest()->take(5)->get() as $reserva)
                        <div class="p-3 border rounded hover:bg-gray-50 flex justify-between items-center">
                            <div>
                                <div class="font-medium">{{ $reserva->quadra->nome ?? '—' }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}
                                    —
                                    {{ $reserva->horario->horario_inicio ?? '—' }}
                                </div>
                            </div>
                            <div class="text-sm">
                                <span class="px-2 py-1 rounded text-xs 
                                    {{ $reserva->status == 'confirmado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($reserva->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
