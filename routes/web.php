<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Controllers ADMIN
use App\Http\Controllers\Admin\ClienteController as AdminClienteController;
use App\Http\Controllers\Admin\QuadraController as AdminQuadraController;
use App\Http\Controllers\Admin\HorarioController as AdminHorarioController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Admin\PagamentoController as AdminPagamentoController;
use App\Http\Controllers\Admin\CancelamentoController as AdminCancelamentoController;
use App\Http\Controllers\Admin\AdminDashboardController;

// Controllers CLIENTE
use App\Http\Controllers\Cliente\ClienteDashboardController;
use App\Http\Controllers\Cliente\ReservaController as ClienteReservaController;
use App\Http\Controllers\Cliente\PagamentoController as ClientePagamentoController;
use App\Http\Controllers\Cliente\PerfilController as ClientePerfilController;

// Controllers SUPER ADMIN
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\EmpresaController;

// Controllers PÚBLICOS
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\QuadraController as PublicQuadraController;

// ===================================================
// ROTAS PÚBLICAS
// ===================================================
Route::get('/', function () {
    return redirect()->route('quadras.public');
});

Route::get('/sobre', [HomeController::class, 'about'])->name('about');
Route::get('/contato', [HomeController::class, 'contact'])->name('contact');
Route::post('/contato', [HomeController::class, 'sendContact'])->name('contact.send');

// Quadras públicas
Route::get('/quadras', [PublicQuadraController::class, 'publicIndex'])->name('quadras.public');
Route::get('/quadras/{quadra}', [PublicQuadraController::class, 'publicShow'])->name('quadras.public.show');
Route::post('/quadras/search', [PublicQuadraController::class, 'publicSearch'])->name('quadras.public.search');

// ===================================================
// AUTENTICAÇÃO
// ===================================================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// ===================================================
// ROTAS PROTEGIDAS (usuário autenticado)
// ===================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // ===================================================
    // ÁREA DO SUPER ADMIN
    // ===================================================
    Route::prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/relatorios', [SuperAdminDashboardController::class, 'relatorios'])->name('relatorios.index');
        Route::get('/relatorios/financeiro', [SuperAdminDashboardController::class, 'relatorioFinanceiro'])->name('relatorios.financeiro');

        // Empresas
        Route::resource('empresas', EmpresaController::class);
        Route::post('/empresas/search', [EmpresaController::class, 'search'])->name('empresas.search');

        Route::resource('clientes', App\Http\Controllers\SuperAdmin\ClienteController::class);
        Route::resource('quadras', App\Http\Controllers\SuperAdmin\QuadraController::class);
        Route::resource('reservas', App\Http\Controllers\SuperAdmin\ReservaController::class);
    });


    // ===================================================
    // ÁREA DO ADMINISTRADOR DA EMPRESA
    // ===================================================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Relatórios do admin
        Route::get('/relatorios', [AdminDashboardController::class, 'relatorios'])->name('relatorios.index');
        Route::get('/relatorios/financeiro', [AdminDashboardController::class, 'relatorioFinanceiro'])->name('relatorios.financeiro');

        // ===================================================
        // CLIENTES
        // ===================================================
        Route::prefix('clientes')->name('clientes.')->group(function () {
            Route::get('/', [AdminClienteController::class, 'index'])->name('index');
            Route::get('/create', [AdminClienteController::class, 'create'])->name('create');
            Route::post('/', [AdminClienteController::class, 'store'])->name('store');
            Route::get('/{cliente}', [AdminClienteController::class, 'show'])->name('show');
            Route::get('/{cliente}/edit', [AdminClienteController::class, 'edit'])->name('edit');
            Route::put('/{cliente}', [AdminClienteController::class, 'update'])->name('update');
            Route::delete('/{cliente}', [AdminClienteController::class, 'destroy'])->name('destroy');
            Route::post('/search', [AdminClienteController::class, 'search'])->name('search');
        });

        // ===================================================
        // QUADRAS
        // ===================================================
        Route::resource('quadras', AdminQuadraController::class);
        Route::post('/quadras/search', [AdminQuadraController::class, 'search'])->name('quadras.search');


        // ===================================================
        // HORÁRIOS
        // ===================================================
        Route::resource('horarios', AdminHorarioController::class);
        Route::post('/horarios/search', [AdminHorarioController::class, 'search'])->name('horarios.search');

        // ===================================================
        // RESERVAS
        // ===================================================

        Route::resource('reservas', AdminReservaController::class);
        Route::post('/reservas/search', [AdminReservaController::class, 'search'])->name('reservas.search');


        // ===================================================
        // PAGAMENTOS
        // ===================================================
        Route::resource('pagamentos', AdminPagamentoController::class);
        Route::post('/pagamentos/search', [AdminPagamentoController::class, 'search'])->name('pagamentos.search');

        // ===================================================
        // CANCELAMENTOS
        // ===================================================
        Route::resource('cancelamentos', AdminCancelamentoController::class);
        Route::post('/cancelamentos/search', [AdminCancelamentoController::class, 'search'])->name('cancelamentos.search');
    });

    // ===================================================
    // ÁREA DO CLIENTE
    // ===================================================
    Route::prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/dashboard', [ClienteDashboardController::class, 'index'])->name('dashboard');

        // Perfil
        Route::prefix('perfil')->name('perfil.')->group(function () {
            Route::get('/', [ClientePerfilController::class, 'show'])->name('show');
            Route::get('/edit', [ClientePerfilController::class, 'edit'])->name('edit');
            Route::put('/update', [ClientePerfilController::class, 'update'])->name('update');
        });

        // Reservas do cliente
        Route::prefix('reservas')->name('reservas.')->group(function () {
            Route::get('/', [ClienteReservaController::class, 'index'])->name('index');
            Route::get('/create', [ClienteReservaController::class, 'create'])->name('create');
            Route::post('/', [ClienteReservaController::class, 'store'])->name('store');
            Route::get('/{reserva}', [ClienteReservaController::class, 'show'])->name('show');
            Route::get('/{reserva}/edit', [ClienteReservaController::class, 'edit'])->name('edit');
            Route::put('/{reserva}', [ClienteReservaController::class, 'update'])->name('update');
            Route::delete('/{reserva}', [ClienteReservaController::class, 'destroy'])->name('destroy');
        });

        // Pagamentos do cliente
        Route::prefix('pagamentos')->name('pagamentos.')->group(function () {
            Route::get('/', [ClientePagamentoController::class, 'index'])->name('index');
            Route::get('/{pagamento}', [ClientePagamentoController::class, 'show'])->name('show');
        });
    });
});
