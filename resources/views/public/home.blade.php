@extends('layouts.home-app')

@section('title', 'Home')

@section('content')

{{-- HERO PRINCIPAL --}}
<section class="relative w-full min-h-[80vh] flex items-center bg-[#27B65C] overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10"
         style="background-image: url('https://www.toptal.com/designers/subtlepatterns/uploads/dot-grid.png'); 
                background-size: 250px;">
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight drop-shadow mb-6">
                Encontre e reserve quadras esportivas
            </h1>
            
            <p class="text-xl md:text-2xl opacity-90 mb-8">
                A maneira mais fácil de agendar sua quadra favorita
            </p>

            {{-- Campo de busca principal --}}
            <div class="bg-white rounded-2xl p-2 shadow-2xl max-w-2xl mx-auto">
                <div class="flex flex-col md:flex-row gap-2">
                    <input 
                        type="text" 
                        placeholder="Em qual cidade você quer jogar?"
                        class="flex-1 px-6 py-4 text-gray-800 border-0 rounded-xl focus:ring-2 focus:ring-[#27B65C] text-lg"
                    >
                    <button class="bg-[#f47b2a] text-white px-8 py-4 rounded-xl font-semibold hover:bg-[#e06a20] transition-all text-lg">
                        Buscar Quadras
                    </button>
                </div>
            </div>

            {{-- Estatísticas --}}
            <div class="grid grid-cols-3 gap-8 mt-12 max-w-2xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold">500+</div>
                    <div class="opacity-80">Quadras</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">50+</div>
                    <div class="opacity-80">Cidades</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">10k+</div>
                    <div class="opacity-80">Reservas</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SESSÃO ESPORTES --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-4">
            Escolha seu esporte
        </h2>
        <p class="text-gray-600 text-center text-lg mb-12 max-w-2xl mx-auto">
            Diversas modalidades disponíveis para você praticar seu esporte favorito
        </p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            {{-- Vôlei de Praia --}}
            <div class="text-center group cursor-pointer">
                <div class="w-20 h-20 bg-[#4486f3] rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xs">VÔLEI PRAIA</span>
                </div>
                <h3 class="font-semibold text-gray-800">Vôlei de Praia</h3>
            </div>

            {{-- Futevôlei --}}
            <div class="text-center group cursor-pointer">
                <div class="w-20 h-20 bg-[#f47b2a] rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xs">FUTEVÔLEI</span>
                </div>
                <h3 class="font-semibold text-gray-800">Futevôlei</h3>
            </div>

            {{-- Beach Tennis --}}
            <div class="text-center group cursor-pointer">
                <div class="w-20 h-20 bg-[#27b65c] rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xs">BEACH TENNIS</span>
                </div>
                <h3 class="font-semibold text-gray-800">Beach Tennis</h3>
            </div>

            {{-- Frescobol --}}
            <div class="text-center group cursor-pointer">
                <div class="w-20 h-20 bg-[#4486f3] rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xs">FRESCOBOL</span>
                </div>
                <h3 class="font-semibold text-gray-800">Frescobol</h3>
            </div>
        </div>
    </div>
</section>

{{-- SESSÃO COMO FUNCIONA --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-4">
            Como funciona
        </h2>
        <p class="text-gray-600 text-center text-lg mb-12 max-w-2xl mx-auto">
            Reserve sua quadra em poucos passos de forma simples e rápida
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            {{-- Passo 1 --}}
            <div class="text-center p-6">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-[#27B65C] rounded-full flex items-center justify-center mx-auto text-white text-2xl font-bold">
                        1
                    </div>
                </div>
                <h3 class="font-bold text-xl mb-3">Encontre quadras</h3>
                <p class="text-gray-600">
                    Busque por quadras disponíveis na sua cidade e escolha a que mais combina com você
                </p>
            </div>

            {{-- Passo 2 --}}
            <div class="text-center p-6">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-[#4486f3] rounded-full flex items-center justify-center mx-auto text-white text-2xl font-bold">
                        2
                    </div>
                </div>
                <h3 class="font-bold text-xl mb-3">Escolha o horário</h3>
                <p class="text-gray-600">
                    Veja os horários disponíveis e selecione o que melhor se encaixa na sua agenda
                </p>
            </div>

            {{-- Passo 3 --}}
            <div class="text-center p-6">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-[#f47b2a] rounded-full flex items-center justify-center mx-auto text-white text-2xl font-bold">
                        3
                    </div>
                </div>
                <h3 class="font-bold text-xl mb-3">Confirme a reserva</h3>
                <p class="text-gray-600">
                    Faça o pagamento e receba a confirmação da sua reserva instantaneamente
                </p>
            </div>
        </div>
    </div>
</section>

{{-- SESSÃO VANTAGENS --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-12">
            Por que usar nossa plataforma?
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            {{-- Vantagem 1 --}}
            <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-[#27b65c] rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Disponibilidade 24h</h3>
                <p class="text-gray-600 text-sm">
                    Reserve a qualquer hora do dia, mesmo de madrugada
                </p>
            </div>

            {{-- Vantagem 2 --}}
            <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-[#4486f3] rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Pagamento Seguro</h3>
                <p class="text-gray-600 text-sm">
                    Sistema de pagamento 100% seguro e criptografado
                </p>
            </div>

            {{-- Vantagem 3 --}}
            <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-[#f47b2a] rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Comunidade</h3>
                <p class="text-gray-600 text-sm">
                    Faça parte de uma comunidade de amantes do esporte
                </p>
            </div>

            {{-- Vantagem 4 --}}
            <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-[#27b65c] rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Agilidade</h3>
                <p class="text-gray-600 text-sm">
                    Processo de reserva rápido e intuitivo
                </p>
            </div>
        </div>
    </div>
</section>

{{-- SESSÃO CTA FINAL --}}
<section class="py-20 bg-[#4486f3]">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-extrabold text-white mb-6">
            Pronto para começar?
        </h2>
        <p class="text-white/90 text-xl mb-8 max-w-2xl mx-auto">
            Junte-se a milhares de pessoas que já descobriram a melhor forma de reservar quadras esportivas.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button class="px-8 py-4 bg-white text-[#4486f3] font-bold rounded-xl hover:bg-gray-100 transition-all text-lg">
                Buscar Quadras Agora
            </button>
            <button onclick="window.location.href='{{ route('about') }}'" 
                    class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-all text-lg">
                Como Funciona
            </button>
        </div>
    </div>
</section>

@endsection