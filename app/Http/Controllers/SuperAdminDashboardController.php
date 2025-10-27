<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Quadra;
use App\Models\Empresa;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
                abort(403, 'Acesso não autorizado. Apenas Super Administradores podem acessar esta área.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $totalEmpresas = Empresa::count();
        $empresasAtivas = Empresa::where('ativa', true)->count();
        $totalClientes = Cliente::count();
        $totalQuadras = Quadra::count();
        $totalReservas = Reserva::count();
        
        $reservasConfirmadas = Reserva::where('status', 'confirmado')->count();
        $reservasPendentes = Reserva::where('status', 'pendente')->count();
        
        $taxaConfirmacao = $totalReservas > 0 ? round(($reservasConfirmadas / $totalReservas) * 100, 2) : 0;
        
        $faturamentoTotal = Reserva::where('status', 'confirmado')->sum('valor_total');
        $faturamentoMensal = Reserva::where('status', 'confirmado')
            ->whereMonth('created_at', now()->month)
            ->sum('valor_total');
        
        $empresas = Empresa::withCount('quadras')->latest()->take(5)->get();
        $reservasRecentes = Reserva::with(['cliente.user', 'quadra.empresa', 'horario'])
            ->latest()
            ->take(10)
            ->get();

        return view('super-admin.dashboard', compact(
            'totalEmpresas',
            'empresasAtivas',
            'totalClientes',
            'totalQuadras',
            'totalReservas',
            'reservasConfirmadas',
            'reservasPendentes',
            'taxaConfirmacao',
            'faturamentoTotal',
            'faturamentoMensal',
            'empresas',
            'reservasRecentes'
        ));
    }

    public function relatorios()
    {
        return view('super-admin.relatorios.index');
    }
}