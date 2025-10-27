@extends('layouts.app')

@section('title', 'Admin - ' . ($pageTitle ?? 'Reserve Quadras'))

@section('content')
    <div class="flex h-screen bg-gray-50">
        <div class="w-64 bg-blue-800 text-white shadow-lg">
            <div class="p-6 border-b border-blue-700">
                <div class="flex items-center justify-center">
                    <div class="text-center">
                        <div class="flex justify-center mb-2">
                            <i class="fas fa-futbol text-3xl text-blue-300"></i>
                        </div>
                        <h1 class="text-xl font-bold">Reserve Quadras</h1>
                        <p class="text-blue-300 text-xs mt-1">Painel Administrativo</p>
                    </div>
                </div>
            </div>

            <nav class="mt-6">
                @php
                    $currentRoute = request()->route()->getName();
                @endphp

                <a href="{{ route('home') }}"
                    class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'home') ? 'bg-blue-700 border-r-4 border-blue-300' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-tachometer-alt w-6 text-center mr-3"></i>
                    <span>Dashboard</span>
                </a>

                @if(auth()->user()->isSuperAdmin())
                    <a href="{{ route('empresas.index') }}"
                        class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'empresas.') ? 'bg-blue-700 border-r-4 border-blue-300' : 'hover:bg-blue-700' }}">
                        <i class="fas fa-building w-6 text-center mr-3"></i>
                        <span>Empresas</span>
                    </a>
                @endif

                <a href="{{ route('clientes.index') }}"
                    class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'clientes.') ? 'bg-blue-700 border-r-4 border-blue-300' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-users w-6 text-center mr-3"></i>
                    <span>Clientes</span>
                </a>

                <a href="{{ route('quadras.index') }}"
                    class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'quadras.') ? 'bg-blue-700 border-r-4 border-blue-300' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-map-marker-alt w-6 text-center mr-3"></i>
                    <span>Quadras</span>
                </a>

                <a href="{{ route('horarios.index') }}"
                    class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'horarios.') ? 'bg-blue-700 border-r-4 border-blue-300' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-clock w-6 text-center mr-3"></i>
                    <span>Horários</span>
                </a>

                <a href="{{ route('reservas.index') }}"
                    class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'reservas.') ? 'bg-blue-700 border-r-4 border-blue-300' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-calendar-alt w-6 text-center mr-3"></i>
                    <span>Reservas</span>
                </a>

                <a href="{{ route('pagamentos.index') }}"
                    class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'pagamentos.') ? 'bg-blue-700 border-r-4 border-blue-300' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-money-bill-wave w-6 text-center mr-3"></i>
                    <span>Pagamentos</span>
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-4 border-t border-blue-700">
                <div class="text-center text-blue-300 text-sm">
                    <p>Reserve Quadras v1.0</p>
                    
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <i class="fas fa-futbol text-2xl text-blue-600 mr-3"></i>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">
                                    @yield('page-title', 'Dashboard')
                                </h1>
                                @hasSection('page-subtitle')
                                    <p class="text-gray-600 text-sm mt-1">@yield('page-subtitle')</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">
                                @if(auth()->user()->isSuperAdmin())
                                    Super Administrador
                                @elseif(auth()->user()->isAdminEmpresa())
                                    Admin - {{ auth()->user()->admin->nome_empresa }}
                                @else
                                    Administrador
                                @endif
                            </p>
                        </div>
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center text-sm focus:outline-none">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-user"></i>
                                </div>
                            </button>

                            <div id="userDropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <div class="px-4 py-2 text-xs text-gray-500 border-b">
                                    Logado como <strong>{{ auth()->user()->email }}</strong>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @hasSection('breadcrumb')
                    <nav class="flex mb-6" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                @endif

                @yield('admin-content')
            </main>

            <footer class="bg-white border-t border-gray-200 py-4 px-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-futbol text-blue-600"></i>
                        <span class="text-sm text-gray-600">
                            &copy; {{ date('Y') }} Reserve Quadras - Todos os direitos reservados.
                        </span>
                    </div>
                    <div class="text-sm text-gray-500">
                        Desenvolvido com <i class="fas fa-heart text-red-500"></i> 
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('userMenuButton').addEventListener('click', function () {
                document.getElementById('userDropdown').classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                const dropdown = document.getElementById('userDropdown');
                const button = document.getElementById('userMenuButton');

                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        </script>
    @endpush
@endsection