<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Quadra;
use App\Models\Horario;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cliente');
    }

    public function index()
    {
        $cliente = auth()->user()->cliente;
        $reservas = Reserva::where('cliente_id', $cliente->id)
            ->with(['quadra.empresa', 'horario'])
            ->latest()
            ->paginate(10);

        return view('cliente.reservas.index', compact('reservas'));
    }

    public function create()
    {
        $cliente = auth()->user()->cliente;
        $quadras = Quadra::where('disponivel', true)
            ->whereHas('empresa', function($query) {
                $query->where('ativa', true);
            })
            ->get();
        $horarios = Horario::where('disponivel', true)->get();

        return view('cliente.reservas.create', compact('quadras', 'horarios'));
    }

    public function store(Request $request)
    {
        $cliente = auth()->user()->cliente;

        $data = $request->validate([
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date|after_or_equal:today',
            'observacoes' => 'nullable|string'
        ]);

        $data['cliente_id'] = $cliente->id;

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

        return redirect()->route('cliente.reservas.index')->with('success', 'Reserva criada com sucesso!');
    }

    public function show(Reserva $reserva)
    {
        $cliente = auth()->user()->cliente;
        if ($reserva->cliente_id != $cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('cliente.reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        $cliente = auth()->user()->cliente;
        if ($reserva->cliente_id != $cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Só permite editar se a reserva estiver pendente
        if ($reserva->status != 'pendente') {
            return redirect()->route('cliente.reservas.index')->with('error', 'Somente reservas pendentes podem ser editadas.');
        }

        $quadras = Quadra::where('disponivel', true)
            ->whereHas('empresa', function($query) {
                $query->where('ativa', true);
            })
            ->get();
        $horarios = Horario::where('disponivel', true)->get();

        return view('cliente.reservas.edit', compact('reserva', 'quadras', 'horarios'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $cliente = auth()->user()->cliente;
        if ($reserva->cliente_id != $cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Só permite editar se a reserva estiver pendente
        if ($reserva->status != 'pendente') {
            return redirect()->route('cliente.reservas.index')->with('error', 'Somente reservas pendentes podem ser editadas.');
        }

        $data = $request->validate([
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date|after_or_equal:today',
            'observacoes' => 'nullable|string'
        ]);

        // Verifica se há conflito com outra reserva (excluindo a própria)
        $reservaExistente = Reserva::where('quadra_id', $data['quadra_id'])
            ->where('horario_id', $data['horario_id'])
            ->where('data_reserva', $data['data_reserva'])
            ->whereIn('status', ['pendente', 'confirmado'])
            ->where('id', '!=', $reserva->id)
            ->exists();

        if ($reservaExistente) {
            return back()->withErrors(['error' => 'Já existe uma reserva para este horário e data.'])->withInput();
        }

        if ($reserva->quadra_id != $data['quadra_id']) {
            $quadra = Quadra::findOrFail($data['quadra_id']);
            $data['valor_total'] = $quadra->preco_hora;
        }

        $reserva->update($data);

        return redirect()->route('cliente.reservas.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(Reserva $reserva)
    {
        $cliente = auth()->user()->cliente;
        if ($reserva->cliente_id != $cliente->id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Só permite cancelar se a reserva estiver pendente ou confirmada
        if (!in_array($reserva->status, ['pendente', 'confirmado'])) {
            return redirect()->route('cliente.reservas.index')->with('error', 'Não é possível cancelar esta reserva.');
        }

        // Altera o status para cancelado
        $reserva->update(['status' => 'cancelado']);

        return redirect()->route('cliente.reservas.index')->with('success', 'Reserva cancelada com sucesso!');
    }

    public function search(Request $request)
    {
        $cliente = auth()->user()->cliente;
        $search = $request->get('search');

        $reservas = Reserva::where('cliente_id', $cliente->id)
            ->whereHas('quadra', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })->with(['quadra.empresa', 'horario'])
            ->paginate(10);

        return view('cliente.reservas.index', compact('reservas'));
    }
}