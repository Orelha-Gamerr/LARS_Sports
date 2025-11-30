<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Quadra;
use App\Models\Horario;
use Illuminate\Http\Request;

class ReservaController extends AdminBaseController
{
    public function index()
    {
        $empresa = $this->empresa;
        $reservas = Reserva::whereHas('quadra', function ($q) use ($empresa) {
            $q->where('empresa_id', $empresa->id);
        })
        ->with(['cliente.user', 'quadra', 'horario'])
        ->orderBy('data_reserva', 'desc')
        ->paginate(10);

        return view('admin.reservas.index', compact('reservas', 'empresa'));
    }

    public function create()
    {
        $empresa = $this->empresa;
        $clientes = Cliente::with('user')->get();
        $quadras = Quadra::where('empresa_id', $empresa->id)->where('disponivel', true)->get();
        $horarios = Horario::whereHas('quadra', fn($q) => $q->where('empresa_id', $empresa->id))
            ->where('disponivel', true)->get();

        return view('admin.reservas.create', compact('clientes', 'quadras', 'horarios', 'empresa'));
    }

    public function store(Request $request)
    {
        $empresa = $this->empresa;

        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date',
            'observacoes' => 'nullable|string'
        ]);

        $quadra = Quadra::findOrFail($data['quadra_id']);
        if ($quadra->empresa_id != $empresa->id) {
            return back()->withErrors(['error' => 'Quadra não pertence à sua empresa.'])->withInput();
        }

        $horario = Horario::findOrFail($data['horario_id']);
        if ($horario->quadra_id != $data['quadra_id']) {
            return back()->withErrors(['error' => 'Horário não pertence à quadra selecionada.'])->withInput();
        }

        $reservaExistente = Reserva::where('quadra_id', $data['quadra_id'])
            ->where('horario_id', $data['horario_id'])
            ->where('data_reserva', $data['data_reserva'])
            ->whereIn('status', ['pendente', 'confirmado'])
            ->exists();

        if ($reservaExistente) {
            return back()->withErrors(['error' => 'Já existe uma reserva neste horário.'])->withInput();
        }

        $data['valor_total'] = $quadra->preco_hora;
        $data['status'] = 'pendente';

        Reserva::create($data);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva criada com sucesso!');
    }

    public function edit(Reserva $reserva)
    {
        $empresa = $this->empresa;
        if ($reserva->quadra->empresa_id != $empresa->id) abort(403);

        $clientes = Cliente::with('user')->get();
        $quadras = Quadra::where('empresa_id', $empresa->id)->where('disponivel', true)->get();
        
        $horarios = Horario::where('quadra_id', $reserva->quadra_id)
            ->where('disponivel', true)
            ->get();

        return view('admin.reservas.edit', compact('reserva', 'clientes', 'quadras', 'horarios'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $empresa = $this->empresa;
        if ($reserva->quadra->empresa_id != $empresa->id) abort(403);

        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date',
            'status' => 'required|in:pendente,confirmado,cancelado,finalizado',
            'valor_total' => 'required|numeric|min:0',
            'observacoes' => 'nullable|string'
        ]);

        $horario = Horario::findOrFail($data['horario_id']);
        if ($horario->quadra_id != $data['quadra_id']) {
            return back()->withErrors(['error' => 'Horário não pertence à quadra selecionada.'])->withInput();
        }

        $conflito = Reserva::where('id', '!=', $reserva->id)
            ->where('quadra_id', $data['quadra_id'])
            ->where('horario_id', $data['horario_id'])
            ->where('data_reserva', $data['data_reserva'])
            ->whereIn('status', ['pendente', 'confirmado'])
            ->exists();

        if ($conflito) {
            return back()->withErrors(['error' => 'Horário já reservado nesta quadra.'])->withInput();
        }

        $reserva->update($data);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(Reserva $reserva)
    {
        if ($reserva->quadra->empresa_id != $this->empresa->id) abort(403);

        $reserva->delete();
        return redirect()->route('admin.reservas.index')->with('success', 'Reserva excluída com sucesso!');
    }

    public function search(Request $request)
    {
        $empresa = $this->empresa;
        $search = $request->search;

        $reservas = Reserva::whereHas('quadra', fn($q) => $q->where('empresa_id', $empresa->id))
            ->where(function($q) use ($search) {
                $q->whereHas('cliente.user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('quadra', fn($qu) => $qu->where('nome', 'like', "%$search%"));
            })
            ->with(['cliente.user', 'quadra', 'horario'])
            ->orderBy('data_reserva', 'desc')
            ->paginate(10);

        return view('admin.reservas.index', compact('reservas'));
    }

    public function getHorariosByQuadra($quadraId)
    {
        $horarios = Horario::where('quadra_id', $quadraId)
            ->where('disponivel', true)
            ->get();

        return response()->json($horarios);
    }
}