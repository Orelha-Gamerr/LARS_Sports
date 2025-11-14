@extends('layouts.admin')

@section('page-title', 'Horários')

@section('admin-content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Listagem de Horários</h1>
            <p class="text-sm text-gray-500">Horários cadastrados para as quadras da empresa</p>
        </div>

        <a href="{{ route('admin.horarios.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Novo Horário
        </a>
    </div>

    <form action="{{ route('admin.horarios.search') }}" method="GET" class="mb-6">
        <div class="flex flex-wrap items-center gap-3">

            <input type="text" name="quadra"
                placeholder="Nome da quadra"
                class="w-64 px-3 py-2 border border-gray-300 rounded"
                value="{{ old('quadra') }}">

            <input type="time" name="horario_inicio"
                class="px-3 py-2 border border-gray-300 rounded"
                value="{{ old('horario_inicio') }}">

            <input type="time" name="horario_fim"
                class="px-3 py-2 border border-gray-300 rounded"
                value="{{ old('horario_fim') }}">

            <select name="disponivel"
                class="px-3 py-2 border border-gray-300 rounded">
                <option value="">Disponível?</option>
                <option value="1" {{ old('disponivel') === "1" ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ old('disponivel') === "0" ? 'selected' : '' }}>Não</option>
            </select>

            <button class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800 flex items-center gap-2">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 font-medium text-gray-700">Quadra</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Início</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Fim</th>
                    <th class="px-4 py-3 font-medium text-gray-700">Disponível</th>
                    <th class="px-4 py-3 font-medium text-gray-700 w-32">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($horarios as $horario)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $horario->quadra->nome }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($horario->horario_inicio)->format('H:i') }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($horario->horario_fim)->format('H:i') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded text-white text-sm
                                {{ $horario->disponivel ? 'bg-green-600' : 'bg-red-600' }}">
                                {{ $horario->disponivel ? 'Sim' : 'Não' }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center gap-4 text-lg">

                                <a href="{{ route('admin.horarios.show', $horario) }}"
                                   class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.horarios.edit', $horario) }}"
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.horarios.destroy', $horario) }}" method="POST"
                                      onsubmit="return confirm('Excluir este horário?')"
                                      class="inline">
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
        {{ $horarios->links() }}
    </div>

</div>
@endsection
