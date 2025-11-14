@extends('layouts.cliente-app')

@section('title', $quadra->nome . ' - Reserve Quadras')

@section('content')
<div class="mb-6">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('cliente.quadras.index') }}" class="text-green-600 hover:text-green-800">Quadras</a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">{{ $quadra->nome }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-green-800">{{ $quadra->nome }}</h1>
    <p class="text-gray-600 mt-2">{{ $quadra->empresa->endereco }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informações da Quadra -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mb-6">
            <div class="h-64 bg-gradient-to-r from-green-400 to-green-600">
                @if($quadra->imagem)
                    <img src="{{ asset('storage/' . $quadra->imagem) }}" alt="{{ $quadra->nome }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-futbol text-white text-8xl"></i>
                    </div>
                @endif
            </div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $quadra->nome }}</h2>
                        <div class="flex items-center mt-2">
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-2 py-1 rounded mr-2 capitalize">{{ $quadra->tipo }}</span>
                            <span class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                4.5 (12 avaliações)
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-green-800">R$ {{ number_format($quadra->preco_hora, 2, ',', '.') }}</p>
                        <p class="text-gray-600">por hora</p>
                    </div>
                </div>

                <p class="text-gray-700 mb-6">{{ $quadra->descricao }}</p>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-users text-green-600 mr-3"></i>
                        <div>
                            <p class="font-medium">Capacidade</p>
                            <p class="text-sm text-gray-600">{{ $quadra->capacidade }} pessoas</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-building text-green-600 mr-3"></i>
                        <div>
                            <p class="font-medium">Empresa</p>
                            <p class="text-sm text-gray-600">{{ $quadra->empresa->nome }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-green-600 mr-3"></i>
                        <div>
                            <p class="font-medium">Contato</p>
                            <p class="text-sm text-gray-600">{{ $quadra->empresa->telefone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horários Disponíveis -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-green-800">Horários Disponíveis</h3>
                <p class="text-sm text-gray-600 mt-1">Selecione um horário para reservar</p>
            </div>
            <div class="p-6">
                @if($horarios->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($horarios as $horario)
                        <div class="border border-gray-200 rounded-lg p-4 text-center hover:border-green-500 hover:bg-green-50 cursor-pointer transition"
                             onclick="selecionarHorario('{{ $horario->id }}', '{{ $horario->horario_inicio }}', '{{ $horario->horario_fim }}')">
                            <p class="font-semibold text-gray-800 text-lg">{{ $horario->horario_inicio }} - {{ $horario->horario_fim }}</p>
                            <p class="text-sm text-gray-600 mt-1">R$ {{ number_format($quadra->preco_hora, 2, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="p-4 bg-yellow-50 rounded-lg inline-block mb-4">
                            <i class="fas fa-clock text-4xl text-yellow-600"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Nenhum horário disponível</h4>
                        <p class="text-gray-600">Entre em contato com a empresa para verificar a disponibilidade.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Card de Reserva -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 sticky top-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-green-800">Fazer Reserva</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('cliente.reservas.store') }}" method="POST" id="reservaForm">
                    @csrf
                    <input type="hidden" name="quadra_id" value="{{ $quadra->id }}">
                    <input type="hidden" name="horario_id" id="horario_id">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data da Reserva *</label>
                        <input type="date" name="data_reserva" id="data_reserva" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               min="{{ date('Y-m-d') }}" required>
                        <p class="text-xs text-gray-500 mt-1">Selecione a data desejada</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Horário Selecionado *</label>
                        <div id="horario_selecionado" class="text-gray-500 italic text-sm">Nenhum horário selecionado</div>
                        <p class="text-xs text-gray-500 mt-1">Clique em um horário disponível acima</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observações (Opcional)</label>
                        <textarea name="observacoes" rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                  placeholder="Alguma observação especial..."></textarea>
                    </div>

                    <div class="mb-6 p-4 bg-green-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Valor da quadra:</span>
                            <span class="font-semibold" id="subtotal">R$ 0,00</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Taxa de serviço:</span>
                            <span class="font-semibold">Grátis</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between items-center text-lg font-bold text-green-800">
                            <span>Total:</span>
                            <span id="total">R$ 0,00</span>
                        </div>
                    </div>

                    <button type="submit" id="btnReservar" 
                            class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center"
                            disabled>
                        <i class="fas fa-calendar-check mr-2"></i>
                        Confirmar Reserva
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function selecionarHorario(horarioId, inicio, fim) {
        document.querySelectorAll('.border-green-500.bg-green-50').forEach(el => {
            el.classList.remove('border-green-500', 'bg-green-50');
            el.classList.add('border-gray-200');
        });

        // Adicionar seleção atual
        event.currentTarget.classList.remove('border-gray-200');
        event.currentTarget.classList.add('border-green-500', 'bg-green-50');

        // Preencher formulário
        document.getElementById('horario_id').value = horarioId;
        document.getElementById('horario_selecionado').innerHTML = 
            `<span class="text-green-600 font-semibold">${inicio} - ${fim}</span>`;
        
        // Calcular valores
        const precoHora = {{ $quadra->preco_hora }};
        document.getElementById('subtotal').textContent = `R$ ${precoHora.toFixed(2).replace('.', ',')}`;
        document.getElementById('total').textContent = `R$ ${precoHora.toFixed(2).replace('.', ',')}`;
        
        // Habilitar botão se a data também estiver selecionada
        const dataSelecionada = document.getElementById('data_reserva').value;
        document.getElementById('btnReservar').disabled = !dataSelecionada;
    }

    // Validar quando a data for alterada
    document.getElementById('data_reserva').addEventListener('change', function() {
        const horarioSelecionado = document.getElementById('horario_id').value;
        document.getElementById('btnReservar').disabled = !horarioSelecionado || !this.value;
    });
</script>
@endsection