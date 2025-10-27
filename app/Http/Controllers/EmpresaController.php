<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSuperAdmin()) {
                abort(403, 'Acesso não autorizado. Apenas Super Admin pode gerenciar empresas.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $empresas = Empresa::paginate(10);
        return view('admin.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('admin.empresas.create');
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

        return redirect()->route('empresas.index')->with('success', 'Empresa criada com sucesso!');
    }

    public function show(Empresa $empresa)
    {
        $empresa->loadCount(['quadras', 'reservas']);
        return view('admin.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('admin.empresas.edit', compact('empresa'));
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

        return redirect()->route('empresas.index')->with('success', 'Empresa atualizada com sucesso!');
    }

    public function destroy(Empresa $empresa)
    {
        if ($empresa->logo) {
            Storage::disk('public')->delete($empresa->logo);
        }
        $empresa->delete();

        return redirect()->route('empresas.index')->with('success', 'Empresa excluída com sucesso!');
    }

    public function toggleStatus(Empresa $empresa)
    {
        $empresa->update(['ativa' => !$empresa->ativa]);
        
        $status = $empresa->ativa ? 'ativada' : 'desativada';
        return redirect()->route('empresas.index')->with('success', "Empresa {$status} com sucesso!");
    }
}