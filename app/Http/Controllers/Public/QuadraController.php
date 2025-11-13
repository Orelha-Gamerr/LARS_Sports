<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Quadra;
use Illuminate\Http\Request;

class QuadraController extends Controller
{
    public function publicIndex()
    {
        $quadras = Quadra::with('empresa')
            ->where('disponivel', true)
            ->whereHas('empresa', function($query) {
                $query->where('ativa', true);
            })
            ->paginate(12);

        return view('public.quadras.index', compact('quadras'));
    }

    public function publicShow(Quadra $quadra)
    {
        if (!$quadra->disponivel || !$quadra->empresa->ativa) {
            abort(404, 'Quadra não encontrada ou indisponível.');
        }

        return view('public.quadras.show', compact('quadra'));
    }

    public function publicSearch(Request $request)
    {
        $search = $request->get('search');
        
        $quadras = Quadra::where('nome', 'like', "%{$search}%")
            ->orWhere('tipo', 'like', "%{$search}%")
            ->orWhereHas('empresa', function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->where('disponivel', true)
            ->whereHas('empresa', function($query) {
                $query->where('ativa', true);
            })
            ->with('empresa')
            ->paginate(12);

        return view('public.quadras.index', compact('quadras'));
    }
}