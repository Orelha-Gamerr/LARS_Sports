<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reserve Quadras')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .gradient-header {
            background: linear-gradient(90deg, #2E7D32 0%, #66BB6A 100%);
        }
        .active-tab {
            border-bottom: 3px solid #2E7D32;
            color: #2E7D32;
            font-weight: 600;
        }
        .day-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .day-circle.active {
            background-color: #2E7D32;
            color: white;
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
                    <a href="{{ route('cliente.dashboard') }}" class="flex flex-col items-center hover:text-green-200 transition">
                        <i class="fas fa-home text-lg"></i>
                        <span class="text-xs mt-1">Home</span>
                    </a>
                    
                    <a href="{{ route('quadras.index') }}" class="flex flex-col items-center hover:text-green-200 transition">
                        <i class="fas fa-map-marker-alt text-lg"></i>
                        <span class="text-xs mt-1">Quadras</span>
                    </a>
                    
                    <a href="{{ route('reservas.index') }}" class="flex flex-col items-center hover:text-green-200 transition">
                        <i class="fas fa-calendar-alt text-lg"></i>
                        <span class="text-xs mt-1">Reservas</span>
                    </a>
                    
                    <a href="{{ route('pagamentos.index') }}" class="flex flex-col items-center hover:text-green-200 transition">
                        <i class="fas fa-money-bill-wave text-lg"></i>
                        <span class="text-xs mt-1">Pagamentos</span>
                    </a>
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <button id="userMenuButton" class="flex flex-col items-center hover:text-green-200 transition">
                            <i class="fas fa-user text-lg"></i>
                            <span class="text-xs mt-1">Conta</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                            <div class="px-4 py-2 text-xs text-gray-500 border-b">
                                Olá, <strong>{{ auth()->user()->name }}</strong>
                            </div>
                            <div class="px-4 py-2 text-xs text-gray-500 border-b">
                                {{ auth()->user()->email }}
                            </div>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Configurações
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <i class="fas fa-futbol text-green-600"></i>
                    <span class="text-sm text-gray-600">
                        &copy; {{ date('Y') }} Reserve Quadras - Todos os direitos reservados.
                    </span>
                </div>
                <div class="text-sm text-gray-500">
                    Precisa de ajuda? <a href="#" class="text-green-600 hover:text-green-700 font-medium">Contate o suporte</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script>
        document.getElementById('userMenuButton')?.addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('userDropdown').classList.toggle('hidden');
        });

        document.addEventListener('click', function() {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });

        document.getElementById('userDropdown')?.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
</body>
</html>