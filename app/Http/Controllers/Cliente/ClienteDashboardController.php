<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Cliente\ClienteBaseController;
use App\Models\Reserva;
use App\Models\Quadra;

class ClienteDashboardController extends ClienteBaseController
{
    protected function checkRole($user)
    {
        if (!$user->isCliente()) {
            return redirect()->route('home')->withErrors('Acesso restrito a clientes.');
        }
        return true;
    }

    public function index()
    {
        $cliente = $this->user->cliente;

        $totalReservas = Reserva::where('cliente_id', $cliente->id)->count();
        $reservasConfirmadas = Reserva::where('cliente_id', $cliente->id)
            ->where('status', 'confirmado')
            ->count();
        
        $reservasPendentes = Reserva::where('cliente_id', $cliente->id)
            ->where('status', 'pendente')
            ->count();

        $totalQuadras = Quadra::where('disponivel', true)->count();
        
        $reservasRecentes = Reserva::where('cliente_id', $cliente->id)
            ->with(['quadra.empresa', 'horario'])
            ->latest()
            ->take(5)
            ->get();

        $valorTotalGasto = Reserva::where('cliente_id', $cliente->id)
            ->where('status', 'confirmado')
            ->sum('valor_total');

        return view('cliente.dashboard', compact(
            'totalReservas',
            'reservasConfirmadas',
            'reservasPendentes',
            'totalQuadras',
            'reservasRecentes',
            'valorTotalGasto'
        ));
    }
}
