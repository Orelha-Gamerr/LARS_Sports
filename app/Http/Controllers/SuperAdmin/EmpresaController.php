<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends SuperAdminBaseController
{

    public function index()
    {
        $empresas = Empresa::withCount(['quadras', 'admins'])->paginate(10);
        return view('super-admin.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('super-admin.empresas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:empresas,cnpj',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email',
            'endereco' => 'required|string',
            'responsavel' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativa' => 'boolean'
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('empresas', 'public');
        }

        Empresa::create($data);

        return redirect()->route('super-admin.empresas.index')->with('success', 'Empresa criada com sucesso!');
    }

    public function show(Empresa $empresa)
    {
        $empresa->loadCount(['quadras', 'reservas', 'admins']);
        $empresa->load(['quadras' => function($query) {
            $query->latest()->take(5);
        }]);

        return view('super-admin.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('super-admin.empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:empresas,cnpj,' . $empresa->id,
            'telefone' => 'required|string|max:20',
            'email' => 'required|email',
            'endereco' => 'required|string',
            'responsavel' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativa' => 'boolean'
        ]);

        if ($request->hasFile('logo')) {
            if ($empresa->logo) {
                Storage::disk('public')->delete($empresa->logo);
            }
            $data['logo'] = $request->file('logo')->store('empresas', 'public');
        }

        $empresa->update($data);

        return redirect()->route('super-admin.empresas.index')->with('success', 'Empresa atualizada com sucesso!');
    }

    public function destroy(Empresa $empresa)
    {
        if ($empresa->logo) {
            Storage::disk('public')->delete($empresa->logo);
        }
        $empresa->delete();

        return redirect()->route('super-admin.empresas.index')->with('success', 'Empresa excluída com sucesso!');
    }

    public function toggleStatus(Empresa $empresa)
    {
        $empresa->update(['ativa' => !$empresa->ativa]);
        
        $status = $empresa->ativa ? 'ativada' : 'desativada';
        return redirect()->route('super-admin.empresas.index')->with('success', "Empresa {$status} com sucesso!");
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $empresas = Empresa::where('nome', 'like', "%{$search}%")
            ->orWhere('cnpj', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('responsavel', 'like', "%{$search}%")
            ->withCount(['quadras', 'admins'])
            ->paginate(10);

        return view('super-admin.empresas.index', compact('empresas'));
    }
}