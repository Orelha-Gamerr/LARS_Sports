<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Quadra;

class AdminDashboardController extends AdminBaseController
{
    protected function checkRole($user)
    {
        if (!$user->isAdminEmpresa()) {
            return redirect()->route('home')->withErrors('Acesso restrito a administradores.');
        }
        return true;
    }

    public function index()
    {
        $user = $this->user;
        $empresa = $user->admin->empresa;

        $totalReservas = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->count();

        $reservasConfirmadas = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where('status', 'confirmado')->count();

        $totalClientes = Cliente::whereHas('reservas', function($query) use ($empresa) {
            $query->whereHas('quadra', function($q) use ($empresa) {
                $q->where('empresa_id', $empresa->id);
            });
        })->distinct()->count();

        $totalQuadras = Quadra::where('empresa_id', $empresa->id)->count();
        $quadrasAtivas = Quadra::where('empresa_id', $empresa->id)->where('disponivel', true)->count();
        
        $reservasRecentes = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->with(['cliente.user', 'quadra', 'horario'])
          ->latest()
          ->take(5)
          ->get();

        $faturamentoMensal = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where('status', 'confirmado')
          ->whereMonth('created_at', now()->month)
          ->sum('valor_total');

        return view('admin.dashboard', compact(
            'totalReservas',
            'reservasConfirmadas',
            'totalClientes',
            'totalQuadras',
            'quadrasAtivas',
            'reservasRecentes',
            'faturamentoMensal',
            'empresa'
        ));
    }

    public function relatorios()
    {
        $empresa = $this->user->admin->empresa;
        return view('admin.relatorios.index', compact('empresa'));
    }

    public function relatorioFinanceiro()
    {
        $empresa = $this->user->admin->empresa;
        return view('admin.relatorios.financeiro', compact('empresa'));
    }
}
