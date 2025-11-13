@extends('layouts.admin')

@section('title', 'Super Admin - ' . ($pageTitle ?? 'Reserve Quadras'))

@section('content')
<div class="flex h-screen bg-gray-50">
    <div class="w-64 bg-purple-800 text-white shadow-lg">
        <div class="p-6 border-b border-purple-700">
            <div class="flex items-center justify-center">
                <div class="text-center">
                    <div class="flex justify-center mb-2">
                        <i class="fas fa-crown text-3xl text-purple-300"></i>
                    </div>
                    <h1 class="text-xl font-bold">Reserve Quadras</h1>
                    <p class="text-purple-300 text-xs mt-1">Super Administrador</p>
                </div>
            </div>
        </div>
        
        <nav class="mt-6">
            @php
                $currentRoute = request()->route()->getName();
            @endphp
            
            <a href="{{ route('super-admin.dashboard') }}" 
               class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'super-admin.') ? 'bg-purple-700 border-r-4 border-purple-300' : 'hover:bg-purple-700' }}">
                <i class="fas fa-tachometer-alt w-6 text-center mr-3"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('super-admin.empresas.index') }}" 
               class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'empresas.') ? 'bg-purple-700 border-r-4 border-purple-300' : 'hover:bg-purple-700' }}">
                <i class="fas fa-building w-6 text-center mr-3"></i>
                <span>Empresas</span>
            </a>

            <a href="{{ route('super-admin.relatorios.index') }}" 
               class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'super-admin.relatorios.index') ? 'bg-purple-700 border-r-4 border-purple-300' : 'hover:bg-purple-700' }}">
                <i class="fas fa-chart-bar w-6 text-center mr-3"></i>
                <span>Relatórios</span>
            </a>
            
            <a href="{{ route('super-admin.clientes.index') }}" 
               class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'clientes.') ? 'bg-purple-700 border-r-4 border-purple-300' : 'hover:bg-purple-700' }}">
                <i class="fas fa-users w-6 text-center mr-3"></i>
                <span>Clientes</span>
            </a>
            
            <a href="{{ route('super-admin.quadras.index') }}" 
               class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'quadras.') ? 'bg-purple-700 border-r-4 border-purple-300' : 'hover:bg-purple-700' }}">
                <i class="fas fa-map-marker-alt w-6 text-center mr-3"></i>
                <span>Quadras</span>
            </a>
            
            <a href="{{ route('super-admin.reservas.index') }}" 
               class="flex items-center py-3 px-6 transition-all duration-200 {{ str_starts_with($currentRoute, 'reservas.') ? 'bg-purple-700 border-r-4 border-purple-300' : 'hover:bg-purple-700' }}">
                <i class="fas fa-calendar-alt w-6 text-center mr-3"></i>
                <span>Reservas</span>
            </a>
        </nav>
        
        <div class="absolute bottom-0 w-64 p-4 border-t border-purple-700">
            <div class="text-center text-purple-300 text-sm">
                <p>Super Admin</p>
                <p class="text-xs mt-1">Controle Total</p>
            </div>
        </div>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex justify-between items-center px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <i class="fas fa-crown text-2xl text-purple-600 mr-3"></i>
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
                        <p class="text-xs text-gray-500">Super Administrador</p>
                    </div>
                    <div class="relative">
                        <button id="userMenuButton" class="flex items-center text-sm focus:outline-none">
                            <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </button>
                        
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <div class="px-4 py-2 text-xs text-gray-500 border-b">
                                Super Admin <strong>{{ auth()->user()->email }}</strong>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('super-admin-content')
        </main>

        <footer class="bg-white border-t border-gray-200 py-4 px-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-crown text-purple-600"></i>
                    <span class="text-sm text-gray-600">
                        &copy; {{ date('Y') }} Reserve Quadras - Super Admin
                    </span>
                </div>
                <div class="text-sm text-gray-500">
                    Sistema Multi-tenant
                </div>
            </div>
        </footer>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('userMenuButton').addEventListener('click', function() {
        document.getElementById('userDropdown').classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const button = document.getElementById('userMenuButton');
        
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection