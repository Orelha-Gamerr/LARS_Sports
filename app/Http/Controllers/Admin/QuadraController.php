<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Quadra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuadraController extends AdminBaseController
{

    public function index()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;
        $quadras = Quadra::where('empresa_id', $empresa->id)->paginate(10);
        return view('admin.quadras.index', compact('quadras', 'empresa'));
    }

    public function create()
    {
        $empresa = auth()->user()->admin->empresa;
        return view('admin.quadras.create', compact('empresa'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:society,futsal,volei,basquete,tenis',
            'descricao' => 'nullable|string',
            'preco_hora' => 'required|numeric|min:0',
            'capacidade' => 'required|integer|min:1',
            'disponivel' => 'boolean',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $data['empresa_id'] = $empresa->id;

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('quadras', 'public');
        }

        Quadra::create($data);

        return redirect()->route('admin.quadras.index')->with('success', 'Quadra criada com sucesso!');
    }

    public function show(Quadra $quadra)
    {
        $user = auth()->user();
        if ($quadra->empresa_id != $user->admin->empresa_id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('admin.quadras.show', compact('quadra'));
    }

    public function edit(Quadra $quadra)
    {
        $user = auth()->user();
        if ($quadra->empresa_id != $user->admin->empresa_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $empresa = $user->admin->empresa;
        return view('admin.quadras.edit', compact('quadra', 'empresa'));
    }

    public function update(Request $request, Quadra $quadra)
    {
        $user = auth()->user();
        if ($quadra->empresa_id != $user->admin->empresa_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:society,futsal,volei,basquete,tenis',
            'descricao' => 'nullable|string',
            'preco_hora' => 'required|numeric|min:0',
            'capacidade' => 'required|integer|min:1',
            'disponivel' => 'boolean',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->hasFile('imagem')) {
            if ($quadra->imagem) {
                Storage::disk('public')->delete($quadra->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('quadras', 'public');
        }

        $quadra->update($data);

        return redirect()->route('admin.quadras.index')->with('success', 'Quadra atualizada com sucesso!');
    }

    public function destroy(Quadra $quadra)
    {
        $user = auth()->user();
        if ($quadra->empresa_id != $user->admin->empresa_id) {
            abort(403, 'Acesso não autorizado.');
        }

        if ($quadra->imagem) {
            Storage::disk('public')->delete($quadra->imagem);
        }
        $quadra->delete();

        return redirect()->route('admin.quadras.index')->with('success', 'Quadra excluída com sucesso!');
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $search = $request->get('search');

        $quadras = Quadra::where('empresa_id', $empresa->id)
            ->where(function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('tipo', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]); // 🔥 Mantém a busca na paginação

        return view('admin.quadras.index', compact('quadras'));
    }

}