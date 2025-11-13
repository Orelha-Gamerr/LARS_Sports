<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Cliente\ClienteBaseController;
use App\Models\Pagamento;
use Illuminate\Http\Request;

class PagamentoController extends ClienteBaseController
{
    public function index()
    {
        $cliente = auth()->user()->cliente;
        $pagamentos = Pagamento::whereHas('reserva', function($query) use ($cliente) {
            $query->where('cliente_id', $cliente->id);
        })->with('reserva.quadra.empresa')->paginate(10);

        return view('cliente.pagamentos.index', compact('pagamentos'));
    }

    public function show(Pagamento $pagamento)
    {
        $cliente = auth()->user()->cliente;
        if ($pagamento->reserva->cliente_id !== $cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('cliente.pagamentos.show', compact('pagamento'));
    }

    public function search(Request $request)
    {
        $cliente = auth()->user()->cliente;
        $search = $request->get('search');

        $pagamentos = Pagamento::whereHas('reserva', function($query) use ($cliente, $search) {
            $query->where('cliente_id', $cliente->id)
                  ->whereHas('quadra', function($q) use ($search) {
                      $q->where('nome', 'like', "%{$search}%");
                  });
        })->orWhere('codigo_transacao', 'like', "%{$search}%")
          ->with('reserva.quadra.empresa')
          ->paginate(10);

        return view('cliente.pagamentos.index', compact('pagamentos'));
    }
}