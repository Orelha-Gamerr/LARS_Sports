<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Quadra;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $horarios = Horario::with('quadra')->paginate(10);
        return view('admin.horarios.index', compact('horarios'));
    }

    public function create()
    {
        $quadras = Quadra::all();
        return view('admin.horarios.create', compact('quadras'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quadra_id' => 'required|exists:quadras,id',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
            'disponivel' => 'boolean'
        ]);

        Horario::create($data);

        return redirect()->route('horarios.index')->with('success', 'Horário criado com sucesso!');
    }

    public function show(Horario $horario)
    {
        return view('admin.horarios.show', compact('horario'));
    }

    public function edit(Horario $horario)
    {
        $quadras = Quadra::all();
        return view('admin.horarios.edit', compact('horario', 'quadras'));
    }

    public function update(Request $request, Horario $horario)
    {
        $data = $request->validate([
            'quadra_id' => 'required|exists:quadras,id',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
            'disponivel' => 'boolean'
        ]);

        $horario->update($data);

        return redirect()->route('horarios.index')->with('success', 'Horário atualizado com sucesso!');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horário excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $horarios = Horario::whereHas('quadra', function ($query) use ($search) {
            $query->where('nome', 'like', "%{$search}%");
        })->with('quadra')
          ->paginate(10);

        return view('admin.horarios.index', compact('horarios'));
    }
}