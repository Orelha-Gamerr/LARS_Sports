<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Quadra;
use App\Models\Empresa;

class SuperAdminDashboardController extends SuperAdminBaseController
{
    protected function checkRole($user)
    {
        if (!$user->isSuperAdmin()) {
            return redirect()->route('home')->withErrors('Acesso restrito a super administradores.');
        }
        return true;
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
