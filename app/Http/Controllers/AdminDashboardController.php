<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Quadra;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->isAdminEmpresa()) {
                abort(403, 'Acesso não autorizado. Apenas administradores de empresa podem acessar esta área.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user = auth()->user();
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
}