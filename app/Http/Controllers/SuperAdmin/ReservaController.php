<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Quadra;
use App\Models\Cliente;
use App\Models\Horario;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservaController extends SuperAdminBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::with(['cliente.user', 'quadra.empresa', 'horario'])
            ->orderBy('data_reserva', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('super-admin.reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::with('user')->get();
        $quadras = Quadra::where('disponivel', true)->with('empresa')->get();
        $horarios = Horario::where('disponivel', true)->get();
        
        return view('super-admin.reservas.create', compact('clientes', 'quadras', 'horarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date|after_or_equal:today',
            'valor_total' => 'required|numeric|min:0',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:pendente,confirmado,cancelado,finalizado',
        ]);

        // Verificar se a quadra está disponível para o horário e data selecionados
        $reservaExistente = Reserva::where('quadra_id', $request->quadra_id)
            ->where('horario_id', $request->horario_id)
            ->where('data_reserva', $request->data_reserva)
            ->where('status', '!=', 'cancelado')
            ->exists();

        if ($reservaExistente) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Esta quadra já está reservada para este horário e data.');
        }

        // Gerar código único para a reserva
        $codigoReserva = 'RES' . strtoupper(uniqid());

        Reserva::create([
            'cliente_id' => $request->cliente_id,
            'quadra_id' => $request->quadra_id,
            'horario_id' => $request->horario_id,
            'data_reserva' => $request->data_reserva,
            'valor_total' => $request->valor_total,
            'observacoes' => $request->observacoes,
            'status' => $request->status,
            'codigo_reserva' => $codigoReserva,
        ]);

        return redirect()->route('super-admin.reservas.index')
            ->with('success', 'Reserva criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        $reserva->load(['cliente.user', 'quadra.empresa', 'horario', 'pagamentos']);
        return view('super-admin.reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        $reserva->load(['cliente.user', 'quadra', 'horario']);
        $clientes = Cliente::with('user')->get();
        $quadras = Quadra::where('disponivel', true)->with('empresa')->get();
        $horarios = Horario::where('disponivel', true)->get();
        
        return view('super-admin.reservas.edit', compact('reserva', 'clientes', 'quadras', 'horarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'quadra_id' => 'required|exists:quadras,id',
            'horario_id' => 'required|exists:horarios,id',
            'data_reserva' => 'required|date',
            'valor_total' => 'required|numeric|min:0',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:pendente,confirmado,cancelado,finalizado',
        ]);

        // Verificar se a quadra está disponível para o horário e data selecionados (exceto para esta reserva)
        $reservaExistente = Reserva::where('quadra_id', $request->quadra_id)
            ->where('horario_id', $request->horario_id)
            ->where('data_reserva', $request->data_reserva)
            ->where('id', '!=', $reserva->id)
            ->where('status', '!=', 'cancelado')
            ->exists();

        if ($reservaExistente) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Esta quadra já está reservada para este horário e data.');
        }

        $reserva->update([
            'cliente_id' => $request->cliente_id,
            'quadra_id' => $request->quadra_id,
            'horario_id' => $request->horario_id,
            'data_reserva' => $request->data_reserva,
            'valor_total' => $request->valor_total,
            'observacoes' => $request->observacoes,
            'status' => $request->status,
        ]);

        return redirect()->route('super-admin.reservas.show', $reserva)
            ->with('success', 'Reserva atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();

        return redirect()->route('super-admin.reservas.index')
            ->with('success', 'Reserva excluída com sucesso!');
    }

    /**
     * Search reservas
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $reservas = Reserva::with(['cliente.user', 'quadra.empresa', 'horario'])
            ->whereHas('cliente.user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('quadra', function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orWhereHas('quadra.empresa', function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orWhere('codigo_reserva', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%")
            ->orderBy('data_reserva', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('super-admin.reservas.index', compact('reservas'));
    }

    /**
     * Update reservation status
     */
    public function updateStatus(Request $request, Reserva $reserva)
    {
        $request->validate([
            'status' => 'required|in:pendente,confirmado,cancelado,finalizado',
        ]);

        $reserva->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status da reserva atualizado com sucesso!');
    }
}
