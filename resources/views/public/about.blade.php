@extends('layouts.home-app')

@section('title', 'Sobre Nós')

@section('content')

<section class="relative w-full min-h-[60vh] flex items-center bg-[#4486f3] overflow-hidden">
    <div class="absolute inset-0 opacity-10"
         style="background-image: url('https://www.toptal.com/designers/subtlepatterns/uploads/dot-grid.png'); 
                background-size: 250px;">
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight drop-shadow mb-6">
                Sobre Nós
            </h1>
            
            <p class="text-xl md:text-2xl opacity-90 max-w-2xl mx-auto">
                Conectando amantes do esporte aos melhores espaços esportivos
            </p>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                    Nossa História
                </h2>
                <p class="text-gray-600 text-lg mb-6">
                    A <span class="font-semibold text-[#4486f3]">Reserve Quadras</span> nasceu da paixão por esportes e da necessidade de simplificar o processo de reserva de quadras. Percebemos que atletas amadores e profissionais enfrentavam dificuldades para encontrar e agendar espaços esportivos de forma prática e eficiente.
                </p>
                <p class="text-gray-600 text-lg mb-6">
                    Em 2024, decidimos criar uma solução que conecta diretamente os amantes de esportes aos melhores espaços esportivos da sua cidade, oferecendo uma experiência de agendamento simples, rápida e segura.
                </p>
                <p class="text-gray-600 text-lg">
                    Hoje, somos referência no segmento, com milhares de reservas realizadas e uma comunidade crescente de usuários satisfeitos.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#27b65c] mb-2">500+</div>
                    <div class="text-gray-600">Quadras Cadastradas</div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#4486f3] mb-2">50+</div>
                    <div class="text-gray-600">Cidades Atendidas</div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#f47b2a] mb-2">10k+</div>
                    <div class="text-gray-600">Reservas Realizadas</div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#27b65c] mb-2">95%</div>
                    <div class="text-gray-600">Satisfação dos Usuários</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-[#27b65c]">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div class="text-white">
                <h2 class="text-3xl font-extrabold mb-6">
                    Para Empresas e Quadras
                </h2>
                <p class="text-lg mb-6 opacity-90">
                    <span class="font-semibold">Aumente sua visibilidade e otimize a gestão da sua quadra</span> cadastrando-se em nossa plataforma.
                </p>
                
                <div class="space-y-4 mb-8">
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-white text-[#27b65c] rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                            ✓
                        </div>
                        <p class="opacity-90">Aumente o alcance da sua quadra para milhares de usuários</p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-white text-[#27b65c] rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                            ✓
                        </div>
                        <p class="opacity-90">Sistema de gestão de reservas automatizado</p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-white text-[#27b65c] rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                            ✓
                        </div>
                        <p class="opacity-90">Controle de horários e disponibilidade em tempo real</p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-white text-[#27b65c] rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                            ✓
                        </div>
                        <p class="opacity-90">Pagamentos seguros e relatórios detalhados</p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-white text-[#27b65c] rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                            ✓
                        </div>
                        <p class="opacity-90">Redução de horários ociosos e aumento da rentabilidade</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button href="{{ route('contact') }}"
                        class="px-6 py-3 bg-white text-[#27b65c] font-semibold rounded-xl hover:bg-gray-100 transition-all">
                        Cadastrar Minha Quadra
                    </button>
                <a href="{{ route('contact') }}" 
                   class="px-6 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition-all text-center">
                    Falar com Comercial
                </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-white border border-white/20">
                    <div class="text-3xl font-bold mb-2">+80%</div>
                    <p class="opacity-90">Aumento na ocupação média das quadras cadastradas</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-white border border-white/20">
                    <div class="text-3xl font-bold mb-2">-60%</div>
                    <p class="opacity-90">Redução no tempo de gestão de reservas</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-white border border-white/20">
                    <div class="text-3xl font-bold mb-2">100%</div>
                    <p class="opacity-90">Pagamentos garantidos e seguros</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-white border border-white/20">
                    <div class="text-3xl font-bold mb-2">24/7</div>
                    <p class="opacity-90">Reservas automáticas a qualquer hora</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-12">
            Nossos Pilares
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {{-- Missão --}}
            <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                <div class="w-20 h-20 bg-[#27b65c] rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-2xl mb-4 text-gray-900">Missão</h3>
                <p class="text-gray-600">
                    Conectar pessoas através do esporte, proporcionando acesso fácil e democrático aos melhores espaços esportivos, promovendo saúde, bem-estar e integração social.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                <div class="w-20 h-20 bg-[#4486f3] rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-2xl mb-4 text-gray-900">Visão</h3>
                <p class="text-gray-600">
                    Ser a principal plataforma de reservas esportivas do Brasil, reconhecida pela excelência no atendimento e pela contribuição para a prática esportiva nacional.
                </p>
            </div>

            {{-- Valores --}}
            <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                <div class="w-20 h-20 bg-[#f47b2a] rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-2xl mb-4 text-gray-900">Valores</h3>
                <div class="text-gray-600 text-left space-y-2">
                    <p>• Transparência e confiança</p>
                    <p>• Inovação constante</p>
                    <p>• Paixão pelo esporte</p>
                    <p>• Compromisso com o usuário</p>
                    <p>• Responsabilidade social</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-4">
            Como Funciona para Quadras
        </h2>
        <p class="text-gray-600 text-center text-lg mb-12 max-w-2xl mx-auto">
            Cadastre sua quadra em poucos passos e comece a receber reservas
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div class="text-center p-6">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-[#27B65C] rounded-full flex items-center justify-center mx-auto text-white text-2xl font-bold">
                        1
                    </div>
                </div>
                <h3 class="font-bold text-xl mb-3">Cadastro da Quadra</h3>
                <p class="text-gray-600">
                    Preencha as informações da sua quadra, fotos, horários e valores
                </p>
            </div>

            <div class="text-center p-6">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-[#4486f3] rounded-full flex items-center justify-center mx-auto text-white text-2xl font-bold">
                        2
                    </div>
                </div>
                <h3 class="font-bold text-xl mb-3">Configuração</h3>
                <p class="text-gray-600">
                    Defina horários disponíveis, preços e formas de pagamento
                </p>
            </div>

            <div class="text-center p-6">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-[#f47b2a] rounded-full flex items-center justify-center mx-auto text-white text-2xl font-bold">
                        3
                    </div>
                </div>
                <h3 class="font-bold text-xl mb-3">Receba Reservas</h3>
                <p class="text-gray-600">
                    Comece a receber reservas e pagamentos automaticamente
                </p>
            </div>
        </div>

        <div class="text-center mt-12">
            <button href="{{ route('contact') }}" 
                class="px-8 py-4 bg-[#4486f3] text-white font-bold rounded-xl hover:bg-[#3a78e0] transition-all text-lg">
                Quero Cadastrar Minha Quadra
            </button>
        </div>
    </div>
</section>

<section class="py-20 bg-[#f47b2a]">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-extrabold text-white mb-6">
            Pronto para Fazer Parte?
        </h2>
        <p class="text-white/90 text-xl mb-8 max-w-2xl mx-auto">
            Seja como usuário buscando quadras ou como empresa cadastrando seus espaços, temos a solução ideal para você.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" 
               class="px-8 py-4 bg-white text-[#f47b2a] font-bold rounded-xl hover:bg-gray-100 transition-all text-lg">
                Buscar Quadras
            </a>
            <a href="{{ route('contact') }}" 
               class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-all text-lg">
                Cadastrar Quadra
            </a>
        </div>
    </div>
</section>


@endsection