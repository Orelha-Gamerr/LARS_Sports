<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reserve Quadras')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .gradient-header {
            background: linear-gradient(90deg, #2E7D32 0%, #66BB6A 100%);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
            <strong class="font-bold">Sucesso! </strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4" role="alert">
            <strong class="font-bold">Erro! </strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- ========== HEADER ========== -->
    <header class="gradient-header text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo e Nome -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-futbol text-2xl"></i>
                    <h1 class="text-xl font-bold">Reserve Quadras</h1>
                </div>

                <!-- Menu de Navegação -->
                <nav class="flex items-center space-x-6">
                    <!-- Link para Home -->
                    <a href="{{ route('home') }}" class="flex flex-col items-center hover:text-green-200 transition">
                        <i class="fas fa-home text-lg"></i>
                        <span class="text-xs mt-1">Home</span>
                    </a>

                    <!-- Link para About -->
                    <a href="{{ route('about') }}" class="flex flex-col items-center hover:text-green-200 transition">
                        <i class="fas fa-building text-lg"></i>
                        <span class="text-xs mt-1">Sobre</span>
                    </a>

                    <!-- Link para Contact -->
                    <a href="{{ route('contact') }}" class="flex flex-col items-center hover:text-green-200 transition">
                        <i class="fas fa-envelope text-lg"></i>
                        <span class="text-xs mt-1">Contato</span>
                    </a>

                    <!-- Botão de Ação Principal -->
                    <a href="{{ route('home') }}#buscar"
                       class="bg-white text-green-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100 transition">
                        Buscar Quadras
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-futbol text-green-400"></i>
                        <span class="text-xl font-bold">Reserve Quadras</span>
                    </div>
                    <p class="text-gray-400">
                        A melhor plataforma para reserva de quadras esportivas do Brasil.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Navegação</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}"
                                class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition">Sobre</a>
                        </li>
                        <li><a href="{{ route('contact') }}"
                                class="text-gray-400 hover:text-white transition">Contato</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Para Empresas</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition">Cadastrar Quadra</a></li>
                        <li><a href="{{ route('about') }}#empresas" class="text-gray-400 hover:text-white transition">Seja Parceiro</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Contato</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            reservequadras@gmail.com
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            (11) 9999-9999
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-comment mr-2"></i>
                            reservecomercial@gmail.com
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Reserve Quadras. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
