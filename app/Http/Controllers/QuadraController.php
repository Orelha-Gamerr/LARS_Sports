<?php

namespace App\Http\Controllers;

use App\Models\Quadra;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuadraController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $quadras = Quadra::with('empresa')->paginate(10);
            return view('admin.quadras.index', compact('quadras'));
        } elseif ($user->isAdminEmpresa()) {
            $empresa = $user->empresa;
            $quadras = Quadra::where('empresa_id', $empresa->id)->paginate(10);
            return view('admin.quadras.index', compact('quadras', 'empresa'));
        } else {
            $quadras = Quadra::with('empresa')
                ->where('disponivel', true)
                ->whereHas('empresa', function($query) {
                    $query->where('ativa', true);
                })
                ->paginate(10);
            return view('cliente.quadras.index', compact('quadras'));
        }
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $empresas = null;
        if (auth()->user()->isSuperAdmin()) {
            $empresas = Empresa::where('ativa', true)->get();
        }

        return view('admin.quadras.create', compact('empresas'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'empresa_id' => auth()->user()->isSuperAdmin() ? 'required|exists:empresas,id' : 'nullable',
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:society,futsal,volei,basquete,tenis',
            'descricao' => 'nullable|string',
            'preco_hora' => 'required|numeric|min:0',
            'capacidade' => 'required|integer|min:1',
            'disponivel' => 'boolean',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if (auth()->user()->isAdminEmpresa()) {
            $data['empresa_id'] = auth()->user()->empresa->id;
        }

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('quadras', 'public');
        }

        Quadra::create($data);

        return redirect()->route('quadras.index')->with('success', 'Quadra criada com sucesso!');
    }

    public function show(Quadra $quadra)
    {
        if (auth()->user()->isAdminEmpresa() && $quadra->empresa_id != auth()->user()->empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        if (auth()->user()->isAdmin()) {
            return view('admin.quadras.show', compact('quadra'));
        } else {
            return view('cliente.quadras.show', compact('quadra'));
        }
    }

    public function edit(Quadra $quadra)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        if (auth()->user()->isAdminEmpresa() && $quadra->empresa_id != auth()->user()->empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $empresas = null;
        if (auth()->user()->isSuperAdmin()) {
            $empresas = Empresa::where('ativa', true)->get();
        }

        return view('admin.quadras.edit', compact('quadra', 'empresas'));
    }

    public function update(Request $request, Quadra $quadra)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        if (auth()->user()->isAdminEmpresa() && $quadra->empresa_id != auth()->user()->empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'empresa_id' => auth()->user()->isSuperAdmin() ? 'required|exists:empresas,id' : 'nullable',
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:society,futsal,volei,basquete,tenis',
            'descricao' => 'nullable|string',
            'preco_hora' => 'required|numeric|min:0',
            'capacidade' => 'required|integer|min:1',
            'disponivel' => 'boolean',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if (auth()->user()->isAdminEmpresa()) {
            unset($data['empresa_id']);
        }

        if ($request->hasFile('imagem')) {
            if ($quadra->imagem) {
                Storage::disk('public')->delete($quadra->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('quadras', 'public');
        }

        $quadra->update($data);

        return redirect()->route('quadras.index')->with('success', 'Quadra atualizada com sucesso!');
    }

    public function destroy(Quadra $quadra)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        if (auth()->user()->isAdminEmpresa() && $quadra->empresa_id != auth()->user()->empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        if ($quadra->imagem) {
            Storage::disk('public')->delete($quadra->imagem);
        }
        $quadra->delete();

        return redirect()->route('quadras.index')->with('success', 'Quadra excluída com sucesso!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $quadras = Quadra::where('nome', 'like', "%{$search}%")
                ->orWhere('tipo', 'like', "%{$search}%")
                ->orWhereHas('empresa', function($query) use ($search) {
                    $query->where('nome', 'like', "%{$search}%");
                })
                ->with('empresa')
                ->paginate(10);
        } elseif ($user->isAdminEmpresa()) {
            $empresa = $user->empresa;
            $quadras = Quadra::where('empresa_id', $empresa->id)
                ->where(function($query) use ($search) {
                    $query->where('nome', 'like', "%{$search}%")
                          ->orWhere('tipo', 'like', "%{$search}%");
                })
                ->paginate(10);
        } else {
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
                ->paginate(10);
        }

        if ($user->isAdmin()) {
            return view('admin.quadras.index', compact('quadras'));
        } else {
            return view('cliente.quadras.index', compact('quadras'));
        }
    }
}