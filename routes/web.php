<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\QuadraController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\CancelamentoController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ClienteDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('quadras.public');
});

Route::get('/sobre', [HomeController::class, 'about'])->name('about');
Route::get('/contato', [HomeController::class, 'contact'])->name('contact');
Route::post('/contato', [HomeController::class, 'sendContact'])->name('contact.send');

Route::get('/quadras', [QuadraController::class, 'publicIndex'])->name('quadras.public');
Route::get('/quadras/{quadra}', [QuadraController::class, 'publicShow'])->name('quadras.public.show');
Route::post('/quadras/search', [QuadraController::class, 'publicSearch'])->name('quadras.public.search');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// ========== ROTAS PROTEGIDAS (requer autenticação) ==========
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // ========== ÁREA DO SUPER ADMIN ==========
    Route::middleware(['super-admin'])->group(function () {
        Route::get('/super-admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('super-admin.dashboard');
        Route::get('/super-admin/relatorios', [SuperAdminDashboardController::class, 'relatorios'])->name('super-admin.relatorios');
        Route::resource('empresas', EmpresaController::class);
        
        Route::post('/empresas/search', [EmpresaController::class, 'search'])->name('empresas.search');
    });

    // ========== ÁREA DO ADMIN DA EMPRESA ==========
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::resource('clientes', ClienteController::class);
        Route::post('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
        
        Route::resource('horarios', HorarioController::class);
        Route::post('/horarios/search', [HorarioController::class, 'search'])->name('horarios.search');
        
        Route::resource('cancelamentos', CancelamentoController::class);
        Route::post('/cancelamentos/search', [CancelamentoController::class, 'search'])->name('cancelamentos.search');
        
        Route::resource('quadras', QuadraController::class);
        Route::post('/quadras/search', [QuadraController::class, 'search'])->name('quadras.search');
        
        Route::resource('pagamentos', PagamentoController::class);
        Route::post('/pagamentos/search', [PagamentoController::class, 'search'])->name('pagamentos.search');
        
        Route::resource('reservas', ReservaController::class);
        Route::post('/reservas/search', [ReservaController::class, 'search'])->name('reservas.search');
    });

    // ========== ÁREA DO CLIENTE (requer autenticação) ==========
    Route::middleware(['cliente'])->group(function () {
        Route::get('/cliente/dashboard', [ClienteDashboardController::class, 'index'])->name('cliente.dashboard');
        
        Route::resource('reservas', ReservaController::class)->except(['index']);
        Route::get('/minhas-reservas', [ReservaController::class, 'index'])->name('reservas.index');
        Route::post('/reservas/search', [ReservaController::class, 'search'])->name('reservas.search');
        
        Route::resource('pagamentos', PagamentoController::class)->only(['index', 'show']);
        Route::post('/pagamentos/search', [PagamentoController::class, 'search'])->name('pagamentos.search');
        
        Route::get('/cliente/perfil', [ClienteController::class, 'profile'])->name('cliente.profile');
        Route::put('/cliente/perfil', [ClienteController::class, 'updateProfile'])->name('cliente.profile.update');
    });

    // ========== ROTAS COMUNS PARA TODOS OS USUÁRIOS AUTENTICADOS ==========
    
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/perfil/alterar-senha', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/perfil/alterar-senha', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});