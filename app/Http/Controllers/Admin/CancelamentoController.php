<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Cancelamento;
use App\Models\Reserva;
use Illuminate\Http\Request;

class CancelamentoController extends AdminBaseController
{


    public function index()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $cancelamentos = Cancelamento::whereHas('reserva.quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->with('reserva.cliente.user', 'reserva.quadra')->paginate(10);

        return view('admin.cancelamentos.index', compact('cancelamentos', 'empresa'));
    }

    public function create()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $reservas = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->whereIn('status', ['pendente', 'confirmado'])->get();

        return view('admin.cancelamentos.create', compact('reservas', 'empresa'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $data = $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'motivo' => 'required|string|max:500',
            'estornar_valor' => 'boolean'
        ]);

        // Verificar se a reserva pertence à empresa
        $reserva = Reserva::findOrFail($data['reserva_id']);
        if ($reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Reserva não pertence a esta empresa.');
        }

        // Atualizar status da reserva
        $reserva->update(['status' => 'cancelado']);

        // Criar cancelamento
        Cancelamento::create($data);

        return redirect()->route('admin.cancelamentos.index')->with('success', 'Cancelamento registrado com sucesso!');
    }

    public function show(Cancelamento $cancelamento)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($cancelamento->reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('admin.cancelamentos.show', compact('cancelamento'));
    }

    public function edit(Cancelamento $cancelamento)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($cancelamento->reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $reservas = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->whereIn('status', ['pendente', 'confirmado'])->get();

        return view('admin.cancelamentos.edit', compact('cancelamento', 'reservas'));
    }

    public function update(Request $request, Cancelamento $cancelamento)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($cancelamento->reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'motivo' => 'required|string|max:500',
            'estornar_valor' => 'boolean'
        ]);

        // Verificar se a nova reserva pertence à empresa
        $reserva = Reserva::findOrFail($data['reserva_id']);
        if ($reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Reserva não pertence a esta empresa.');
        }

        $cancelamento->update($data);

        return redirect()->route('admin.cancelamentos.index')->with('success', 'Cancelamento atualizado com sucesso!');
    }

    public function destroy(Cancelamento $cancelamento)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($cancelamento->reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $cancelamento->delete();

        return redirect()->route('admin.cancelamentos.index')->with('success', 'Cancelamento excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $search = $request->get('search');
        $cancelamentos = Cancelamento::whereHas('reserva.quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where(function($query) use ($search) {
            $query->whereHas('reserva.cliente.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('motivo', 'like', "%{$search}%");
        })->with('reserva.cliente.user', 'reserva.quadra')
          ->paginate(10);

        return view('admin.cancelamentos.index', compact('cancelamentos'));
    }
}