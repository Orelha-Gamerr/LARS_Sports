<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $clientes = Cliente::with('user')->paginate(10);
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:clientes,cpf',
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Cliente::create([
            'user_id' => $user->id,
            'telefone' => $data['telefone'],
            'cpf' => $data['cpf'],
            'data_nascimento' => $data['data_nascimento'],
            'endereco' => $data['endereco']
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $cliente->user_id,
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:clientes,cpf,' . $cliente->id,
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string'
        ]);

        $cliente->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $cliente->update([
            'telefone' => $data['telefone'],
            'cpf' => $data['cpf'],
            'data_nascimento' => $data['data_nascimento'],
            'endereco' => $data['endereco']
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $user = $cliente->user;
        $cliente->delete();
        $user->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $clientes = Cliente::whereHas('user', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->orWhere('cpf', 'like', "%{$search}%")
          ->with('user')
          ->paginate(10);

        return view('admin.clientes.index', compact('clientes'));
    }
}