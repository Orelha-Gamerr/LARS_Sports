@extends('layouts.admin')

@section('page-title', 'Editar Horário')

@section('admin-content')
<div class="p-6">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold">Editar Horário</h1>
        <p class="text-sm text-gray-500">Altere as informações do horário selecionado</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">

        <form action="{{ route('admin.horarios.update', $horario) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium">Quadra</label>
                <select name="quadra_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">

                    @foreach ($quadras as $quadra)
                        <option value="{{ $quadra->id }}" 
                            {{ $quadra->id == $horario->quadra_id ? 'selected' : '' }}>
                            {{ $quadra->nome }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Horário de Início</label>
                <input type="time" name="horario_inicio"
                       value="{{ \Carbon\Carbon::parse($horario->horario_inicio)->format('H:i') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-1 font-medium">Horário de Fim</label>
                <input type="time" name="horario_fim"
                       value="{{ \Carbon\Carbon::parse($horario->horario_fim)->format('H:i') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="disponivel" value="1"
                       {{ $horario->disponivel ? 'checked' : '' }}>
                <label class="font-medium">Disponível</label>
            </div>

            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('admin.horarios.index') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700">
                    Voltar
                </a>

                <button type="submit"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Atualizar Horário
                </button>

            </div>

        </form>

    </div>

</div>
@endsection
