@extends('layouts.admin')

@section('page-title', 'Detalhes do Horário')

@section('admin-content')
<div class="p-6">

    <h1 class="text-2xl font-semibold mb-4">Detalhes do Horário</h1>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">

        <p><strong>Quadra:</strong> {{ $horario->quadra->nome }}</p>

        <p><strong>Horário de Início:</strong>
            {{ \Carbon\Carbon::parse($horario->horario_inicio)->format('H:i') }}
        </p>

        <p><strong>Horário de Fim:</strong>
            {{ \Carbon\Carbon::parse($horario->horario_fim)->format('H:i') }}
        </p>

        <p><strong>Disponível:</strong>
            {{ $horario->disponivel ? 'Sim' : 'Não' }}
        </p>

        <div class="pt-4">
            <a href="{{ route('admin.horarios.index') }}"
               class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800">
                Voltar
            </a>
        </div>

    </div>

</div>
@endsection
