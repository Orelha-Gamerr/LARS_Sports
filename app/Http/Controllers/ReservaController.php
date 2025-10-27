<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Quadra;
use App\Models\Horario;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $reservas = Reserva::with(['cliente.user', 'quadra', 'horario'])->paginate(10);
            return view('admin.reservas.index', compact('reservas'));
        } else {
            $cliente = auth()->user()->cliente;
            $reservas = Reserva::where('cliente_id', $cliente->id)
                ->with(['quadra', 'horario'])
                ->paginate(10);
            return view('cliente.reservas.index', compact('reservas'));
        }
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            $clientes = Cliente::with('user')->get();
        } else {
            $clientes = collect([auth()->user()->cliente]);
        }
        
        $quadras = Quadra::where('disponivel', true)->get();
        $horarios = Horario::where('disponivel', true)->get();

        return auth()->user()->isAdmin() 
            ? view('admin.reservas.create', compact('clientes', 'quadras', 'horarios'))
            : view('cliente.reservas.create', compact('clientes', 'quadras', 'horarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date|after_or_equal:today',
            'observacoes' => 'nullable|string'
        ]);

        if (!auth()->user()->isAdmin() && $data['cliente_id'] != auth()->user()->cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $reservaExistente = Reserva::where('quadra_id', $data['quadra_id'])
            ->where('horario_id', $data['horario_id'])
            ->where('data_reserva', $data['data_reserva'])
            ->whereIn('status', ['pendente', 'confirmado'])
            ->exists();

        if ($reservaExistente) {
            return back()->withErrors(['error' => 'Já existe uma reserva para este horário e data.'])->withInput();
        }

        $quadra = Quadra::findOrFail($data['quadra_id']);
        $data['valor_total'] = $quadra->preco_hora;
        $data['status'] = 'pendente';

        Reserva::create($data);

        return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso!');
    }

    public function show(Reserva $reserva)
    {
        if (!auth()->user()->isAdmin() && $reserva->cliente_id != auth()->user()->cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return auth()->user()->isAdmin() 
            ? view('admin.reservas.show', compact('reserva'))
            : view('cliente.reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        if (!auth()->user()->isAdmin() && $reserva->cliente_id != auth()->user()->cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        if (auth()->user()->isAdmin()) {
            $clientes = Cliente::with('user')->get();
        } else {
            $clientes = collect([auth()->user()->cliente]);
        }
        
        $quadras = Quadra::where('disponivel', true)->get();
        $horarios = Horario::where('disponivel', true)->get();

        return auth()->user()->isAdmin() 
            ? view('admin.reservas.edit', compact('reserva', 'clientes', 'quadras', 'horarios'))
            : view('cliente.reservas.edit', compact('reserva', 'clientes', 'quadras', 'horarios'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        if (!auth()->user()->isAdmin() && $reserva->cliente_id != auth()->user()->cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date|after_or_equal:today',
            'status' => auth()->user()->isAdmin() ? 'required|in:pendente,confirmado,cancelado,finalizado' : 'nullable',
            'observacoes' => 'nullable|string'
        ]);

        if (!auth()->user()->isAdmin()) {
            unset($data['status']);
        }

        if ($reserva->quadra_id != $data['quadra_id']) {
            $quadra = Quadra::findOrFail($data['quadra_id']);
            $data['valor_total'] = $quadra->preco_hora;
        }

        $reserva->update($data);

        return redirect()->route('reservas.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(Reserva $reserva)
    {
        if (!auth()->user()->isAdmin() && $reserva->cliente_id != auth()->user()->cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva excluída com sucesso!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        
        if (auth()->user()->isAdmin()) {
            $reservas = Reserva::whereHas('cliente.user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })->orWhereHas('quadra', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })->with(['cliente.user', 'quadra', 'horario'])
              ->paginate(10);
        } else {
            $cliente = auth()->user()->cliente;
            $reservas = Reserva::where('cliente_id', $cliente->id)
                ->whereHas('quadra', function ($query) use ($search) {
                    $query->where('nome', 'like', "%{$search}%");
                })->with(['quadra', 'horario'])
                ->paginate(10);
        }

        return auth()->user()->isAdmin() 
            ? view('admin.reservas.index', compact('reservas'))
            : view('cliente.reservas.index', compact('reservas'));
    }
}