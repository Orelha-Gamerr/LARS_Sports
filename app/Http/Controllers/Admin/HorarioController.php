<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Horario;
use App\Models\Quadra;
use Illuminate\Http\Request;

class HorarioController extends AdminBaseController
{
    public function index()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $horarios = Horario::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->with('quadra')->paginate(10);

        return view('admin.horarios.index', compact('horarios', 'empresa'));
    }

    public function create()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $quadras = Quadra::where('empresa_id', $empresa->id)->get();
        return view('admin.horarios.create', compact('quadras', 'empresa'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $data = $request->validate([
            'quadra_id' => 'required|exists:quadras,id',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
            'disponivel' => 'boolean'
        ]);

        $quadra = Quadra::findOrFail($data['quadra_id']);
        if ($quadra->empresa_id != $empresa->id) {
            abort(403, 'Quadra não pertence a esta empresa.');
        }

        Horario::create($data);

        return redirect()->route('admin.horarios.index')->with('success', 'Horário criado com sucesso!');
    }

    public function show(Horario $horario)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($horario->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('admin.horarios.show', compact('horario'));
    }

    public function edit(Horario $horario)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($horario->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $quadras = Quadra::where('empresa_id', $empresa->id)->get();
        return view('admin.horarios.edit', compact('horario', 'quadras'));
    }

    public function update(Request $request, Horario $horario)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($horario->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'quadra_id' => 'required|exists:quadras,id',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
            'disponivel' => 'boolean'
        ]);

        $quadra = Quadra::findOrFail($data['quadra_id']);
        if ($quadra->empresa_id != $empresa->id) {
            abort(403, 'Quadra não pertence a esta empresa.');
        }

        $horario->update($data);

        return redirect()->route('admin.horarios.index')->with('success', 'Horário atualizado com sucesso!');
    }

    public function destroy(Horario $horario)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($horario->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $horario->delete();

        return redirect()->route('admin.horarios.index')->with('success', 'Horário excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $quadra = $request->quadra;
        $horario_inicio = $request->horario_inicio;
        $horario_fim = $request->horario_fim;
        $disponivel = $request->disponivel;

        $horarios = Horario::whereHas('quadra', function ($query) use ($empresa, $quadra) {
            $query->where('empresa_id', $empresa->id);

            if (!empty($quadra)) {
                $query->where('nome', 'like', "%{$quadra}%");
            }
        })
        ->when($horario_inicio, function ($q) use ($horario_inicio) {
            $q->where('horario_inicio', '>=', $horario_inicio);
        })
        ->when($horario_fim, function ($q) use ($horario_fim) {
            $q->where('horario_fim', '<=', $horario_fim);
        })
        ->when($disponivel !== null && $disponivel !== "", function ($q) use ($disponivel) {
            $q->where('disponivel', $disponivel);
        })
        ->with('quadra')
        ->paginate(10);

        return view('admin.horarios.index', compact('horarios'));
    }
}

