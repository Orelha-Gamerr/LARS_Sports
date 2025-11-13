<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Quadra;
use App\Models\Horario;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $reservas = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->with(['cliente.user', 'quadra', 'horario'])->paginate(10);

        return view('admin.reservas.index', compact('reservas', 'empresa'));
    }

    public function create()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $clientes = Cliente::with('user')->get();
        $quadras = Quadra::where('empresa_id', $empresa->id)->where('disponivel', true)->get();
        $horarios = Horario::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where('disponivel', true)->get();

        return view('admin.reservas.create', compact('clientes', 'quadras', 'horarios', 'empresa'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date|after_or_equal:today',
            'observacoes' => 'nullable|string'
        ]);

        // Verificar se a quadra pertence à empresa
        $quadra = Quadra::findOrFail($data['quadra_id']);
        if ($quadra->empresa_id != $empresa->id) {
            abort(403, 'Quadra não pertence a esta empresa.');
        }

        $reservaExistente = Reserva::where('quadra_id', $data['quadra_id'])
            ->where('horario_id', $data['horario_id'])
            ->where('data_reserva', $data['data_reserva'])
            ->whereIn('status', ['pendente', 'confirmado'])
            ->exists();

        if ($reservaExistente) {
            return back()->withErrors(['error' => 'Já existe uma reserva para este horário e data.'])->withInput();
        }

        $data['valor_total'] = $quadra->preco_hora;
        $data['status'] = 'pendente';

        Reserva::create($data);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva criada com sucesso!');
    }

    public function show(Reserva $reserva)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $clientes = Cliente::with('user')->get();
        $quadras = Quadra::where('empresa_id', $empresa->id)->where('disponivel', true)->get();
        $horarios = Horario::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where('disponivel', true)->get();

        return view('admin.reservas.edit', compact('reserva', 'clientes', 'quadras', 'horarios'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date|after_or_equal:today',
            'status' => 'required|in:pendente,confirmado,cancelado,finalizado',
            'observacoes' => 'nullable|string'
        ]);

        // Verificar se a nova quadra pertence à empresa
        $quadra = Quadra::findOrFail($data['quadra_id']);
        if ($quadra->empresa_id != $empresa->id) {
            abort(403, 'Quadra não pertence a esta empresa.');
        }

        if ($reserva->quadra_id != $data['quadra_id']) {
            $data['valor_total'] = $quadra->preco_hora;
        }

        $reserva->update($data);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(Reserva $reserva)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $reserva->delete();

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva excluída com sucesso!');
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $search = $request->get('search');
        $reservas = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where(function($query) use ($search) {
            $query->whereHas('cliente.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('quadra', function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%");
            });
        })->with(['cliente.user', 'quadra', 'horario'])
          ->paginate(10);

        return view('admin.reservas.index', compact('reservas'));
    }
}