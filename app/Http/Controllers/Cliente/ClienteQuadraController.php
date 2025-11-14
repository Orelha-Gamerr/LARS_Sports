<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quadra;
use App\Models\Empresa;
use Illuminate\Support\Str;

class ClienteQuadraController extends Controller
{
    public function index()
    {
        // Buscar todas as quadras disponíveis com suas empresas ativas
        $quadras = Quadra::with(['empresa' => function($query) {
                $query->where('ativa', true);
            }])
            ->where('disponivel', true)
            ->orderBy('nome')
            ->paginate(12);

        return view('cliente.quadras.index', compact('quadras'));
    }

    public function show($id)
    {
        // Buscar a quadra específica com empresa ativa
        $quadra = Quadra::with(['empresa' => function($query) {
                $query->where('ativa', true);
            }])
            ->where('disponivel', true)
            ->findOrFail($id);

        // Buscar horários disponíveis para esta quadra
        $horarios = $quadra->horarios()
            ->where('disponivel', true)
            ->orderBy('horario_inicio')
            ->get();

        return view('cliente.quadras.show', compact('quadra', 'horarios'));
    }

    public function search(Request $request)
    {
        $query = Quadra::with(['empresa' => function($query) {
                $query->where('ativa', true);
            }])
            ->where('disponivel', true);

        // Aplicar filtros
        if ($request->has('localizacao') && $request->localizacao != '') {
            // Buscar por empresas na localização
            $query->whereHas('empresa', function($q) use ($request) {
                $q->where('endereco', 'like', '%' . $request->localizacao . '%');
            });
        }

        if ($request->has('modalidade') && $request->modalidade != '') {
            $query->where('tipo', $request->modalidade);
        }

        $quadras = $query->orderBy('nome')->paginate(12);

        return view('cliente.quadras.index', compact('quadras'));
    }
}