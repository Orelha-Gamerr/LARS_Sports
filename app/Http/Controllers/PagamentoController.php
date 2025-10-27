<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\Reserva;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $pagamentos = Pagamento::with('reserva.cliente.user', 'reserva.quadra')->paginate(10);
            return view('admin.pagamentos.index', compact('pagamentos'));
        } else {
            $cliente = auth()->user()->cliente;
            $pagamentos = Pagamento::whereHas('reserva', function($query) use ($cliente) {
                $query->where('cliente_id', $cliente->id);
            })->with('reserva.quadra')->paginate(10);
            return view('cliente.pagamentos.index', compact('pagamentos'));
        }
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $reservas = Reserva::where('status', 'confirmado')->get();
        return view('admin.pagamentos.create', compact('reservas'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'valor' => 'required|numeric|min:0',
            'metodo' => 'required|in:pix,cartao_credito,cartao_debito,dinheiro',
            'status' => 'required|in:pendente,pago,cancelado,estornado',
            'codigo_transacao' => 'nullable|string|max:255'
        ]);

        Pagamento::create($data);

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento registrado com sucesso!');
    }

    public function show(Pagamento $pagamento)
    {
        if (auth()->user()->isAdmin()) {
            return view('admin.pagamentos.show', compact('pagamento'));
        } else {
            $cliente = auth()->user()->cliente;
            if ($pagamento->reserva->cliente_id !== $cliente->id) {
                abort(403, 'Acesso não autorizado.');
            }
            return view('cliente.pagamentos.show', compact('pagamento'));
        }
    }

    public function edit(Pagamento $pagamento)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $reservas = Reserva::where('status', 'confirmado')->get();
        return view('admin.pagamentos.edit', compact('pagamento', 'reservas'));
    }

    public function update(Request $request, Pagamento $pagamento)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'valor' => 'required|numeric|min:0',
            'metodo' => 'required|in:pix,cartao_credito,cartao_debito,dinheiro',
            'status' => 'required|in:pendente,pago,cancelado,estornado',
            'codigo_transacao' => 'nullable|string|max:255'
        ]);

        $pagamento->update($data);

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado com sucesso!');
    }

    public function destroy(Pagamento $pagamento)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $pagamento->delete();

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        
        if (auth()->user()->isAdmin()) {
            $pagamentos = Pagamento::whereHas('reserva.cliente.user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })->orWhere('codigo_transacao', 'like', "%{$search}%")
              ->with('reserva.cliente.user', 'reserva.quadra')
              ->paginate(10);
            
            return view('admin.pagamentos.index', compact('pagamentos'));
        } else {
            $cliente = auth()->user()->cliente;
            $pagamentos = Pagamento::whereHas('reserva', function($query) use ($cliente, $search) {
                $query->where('cliente_id', $cliente->id)
                      ->whereHas('quadra', function($q) use ($search) {
                          $q->where('nome', 'like', "%{$search}%");
                      });
            })->orWhere('codigo_transacao', 'like', "%{$search}%")
              ->with('reserva.quadra')
              ->paginate(10);
            
            return view('cliente.pagamentos.index', compact('pagamentos'));
        }
    }
}