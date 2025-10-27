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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/cliente/dashboard', [ClienteDashboardController::class, 'index'])->name('cliente.dashboard');

    Route::middleware(['auth', 'super-admin'])->group(function () {
    Route::get('/super-admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('super-admin.dashboard');
    Route::get('/super-admin/relatorios', [SuperAdminDashboardController::class, 'relatorios'])->name('super-admin.relatorios');
    Route::resource('empresas', EmpresaController::class);
});


    Route::middleware(['admin'])->group(function () {
        Route::resource('clientes', ClienteController::class);
        Route::resource('horarios', HorarioController::class);
        Route::resource('cancelamentos', CancelamentoController::class);
        
        Route::post('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
        Route::post('/horarios/search', [HorarioController::class, 'search'])->name('horarios.search');
        Route::post('/cancelamentos/search', [CancelamentoController::class, 'search'])->name('cancelamentos.search');
    });

    Route::resource('quadras', QuadraController::class)->only(['index', 'show']);
    Route::resource('reservas', ReservaController::class);
    Route::resource('pagamentos', PagamentoController::class)->only(['index', 'show']);

    Route::post('/quadras/search', [QuadraController::class, 'search'])->name('quadras.search');
    Route::post('/reservas/search', [ReservaController::class, 'search'])->name('reservas.search');
    Route::post('/pagamentos/search', [PagamentoController::class, 'search'])->name('pagamentos.search');

    Route::middleware(['admin'])->group(function () {
        Route::get('/quadras/create', [QuadraController::class, 'create'])->name('quadras.create');
        Route::post('/quadras', [QuadraController::class, 'store'])->name('quadras.store');
        Route::get('/quadras/{quadra}/edit', [QuadraController::class, 'edit'])->name('quadras.edit');
        Route::put('/quadras/{quadra}', [QuadraController::class, 'update'])->name('quadras.update');
        Route::delete('/quadras/{quadra}', [QuadraController::class, 'destroy'])->name('quadras.destroy');

        Route::get('/pagamentos/create', [PagamentoController::class, 'create'])->name('pagamentos.create');
        Route::post('/pagamentos', [PagamentoController::class, 'store'])->name('pagamentos.store');
        Route::get('/pagamentos/{pagamento}/edit', [PagamentoController::class, 'edit'])->name('pagamentos.edit');
        Route::put('/pagamentos/{pagamento}', [PagamentoController::class, 'update'])->name('pagamentos.update');
        Route::delete('/pagamentos/{pagamento}', [PagamentoController::class, 'destroy'])->name('pagamentos.destroy');
    });
});