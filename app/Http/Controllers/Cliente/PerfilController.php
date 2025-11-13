<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cliente');
    }

    public function show()
    {
        $cliente = auth()->user()->cliente;
        return view('cliente.perfil.show', compact('cliente'));
    }

    public function edit()
    {
        $cliente = auth()->user()->cliente;
        return view('cliente.perfil.edit', compact('cliente'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $cliente = $user->cliente;

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:clientes,cpf,' . $cliente->id,
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string'
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $cliente->update([
            'telefone' => $data['telefone'],
            'cpf' => $data['cpf'],
            'data_nascimento' => $data['data_nascimento'],
            'endereco' => $data['endereco']
        ]);

        return redirect()->route('cliente.perfil.show')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Senha atual incorreta.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('cliente.perfil.show')->with('success', 'Senha alterada com sucesso!');
    }
}