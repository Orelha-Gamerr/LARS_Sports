<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClienteController extends SuperAdminBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('super-admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super-admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:clientes',
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Criar usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Upload da foto se fornecida
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('clientes', 'public');
        }

        // Criar cliente
        Cliente::create([
            'user_id' => $user->id,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'endereco' => $request->endereco,
            'foto' => $fotoPath,
        ]);

        // Atribuir papel de cliente
        $user->assignRole('cliente');

        return redirect()->route('super-admin.clientes.index')
            ->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load('user', 'reservas.quadra.empresa');
        return view('super-admin.clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $cliente->load('user');
        return view('super-admin.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $user = $cliente->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:clientes,cpf,' . $cliente->id,
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Atualizar usuário
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Upload da foto se fornecida
        if ($request->hasFile('foto')) {
            // Deletar foto antiga se existir
            if ($cliente->foto && Storage::disk('public')->exists($cliente->foto)) {
                Storage::disk('public')->delete($cliente->foto);
            }
            
            $fotoPath = $request->file('foto')->store('clientes', 'public');
            $cliente->foto = $fotoPath;
        }

        // Atualizar cliente
        $cliente->update([
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'endereco' => $request->endereco,
            'foto' => $cliente->foto,
        ]);

        return redirect()->route('super-admin.clientes.show', $cliente)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Deletar foto se existir
        if ($cliente->foto && Storage::disk('public')->exists($cliente->foto)) {
            Storage::disk('public')->delete($cliente->foto);
        }

        // Deletar usuário relacionado
        $cliente->user->delete();
        // O cliente será deletado automaticamente devido ao cascade

        return redirect()->route('super-admin.clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }

    /**
     * Search clients
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $clientes = Cliente::with('user')
            ->whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('cpf', 'like', "%{$search}%")
            ->orWhere('telefone', 'like', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('super-admin.clientes.index', compact('clientes'));
    }
}
