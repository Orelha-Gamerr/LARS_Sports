<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Quadra;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuadraController extends SuperAdminBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quadras = Quadra::with('empresa')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('super-admin.quadras.index', compact('quadras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = Empresa::where('ativa', true)->get();
        return view('super-admin.quadras.create', compact('empresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|in:society,futsal,volei,basquete,tenis',
            'descricao' => 'nullable|string',
            'preco_hora' => 'required|numeric|min:0',
            'capacidade' => 'required|integer|min:1',
            'disponivel' => 'boolean',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload da imagem se fornecida
        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('quadras', 'public');
        }

        Quadra::create([
            'empresa_id' => $request->empresa_id,
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'descricao' => $request->descricao,
            'preco_hora' => $request->preco_hora,
            'capacidade' => $request->capacidade,
            'disponivel' => $request->has('disponivel') ? true : false,
            'imagem' => $imagemPath,
        ]);

        return redirect()->route('super-admin.quadras.index')
            ->with('success', 'Quadra criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quadra $quadra)
    {
        $quadra->load('empresa', 'horarios', 'reservas.cliente.user');
        return view('super-admin.quadras.show', compact('quadra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quadra $quadra)
    {
        $empresas = Empresa::where('ativa', true)->get();
        return view('super-admin.quadras.edit', compact('quadra', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quadra $quadra)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|in:society,futsal,volei,basquete,tenis',
            'descricao' => 'nullable|string',
            'preco_hora' => 'required|numeric|min:0',
            'capacidade' => 'required|integer|min:1',
            'disponivel' => 'boolean',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload da nova imagem se fornecida
        if ($request->hasFile('imagem')) {
            // Deletar imagem antiga se existir
            if ($quadra->imagem && Storage::disk('public')->exists($quadra->imagem)) {
                Storage::disk('public')->delete($quadra->imagem);
            }
            
            $imagemPath = $request->file('imagem')->store('quadras', 'public');
            $quadra->imagem = $imagemPath;
        }

        $quadra->update([
            'empresa_id' => $request->empresa_id,
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'descricao' => $request->descricao,
            'preco_hora' => $request->preco_hora,
            'capacidade' => $request->capacidade,
            'disponivel' => $request->has('disponivel') ? true : false,
            'imagem' => $quadra->imagem,
        ]);

        return redirect()->route('super-admin.quadras.show', $quadra)
            ->with('success', 'Quadra atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quadra $quadra)
    {
        // Deletar imagem se existir
        if ($quadra->imagem && Storage::disk('public')->exists($quadra->imagem)) {
            Storage::disk('public')->delete($quadra->imagem);
        }

        $quadra->delete();

        return redirect()->route('super-admin.quadras.index')
            ->with('success', 'Quadra excluída com sucesso!');
    }

    /**
     * Search quadras
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $quadras = Quadra::with('empresa')
            ->where('nome', 'like', "%{$search}%")
            ->orWhere('tipo', 'like', "%{$search}%")
            ->orWhereHas('empresa', function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('super-admin.quadras.index', compact('quadras'));
    }
}
