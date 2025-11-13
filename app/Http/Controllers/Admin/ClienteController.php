<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends AdminBaseController
{

    public function index()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        // Clientes que fizeram reservas nas quadras da empresa
        $clientes = Cliente::whereHas('reservas', function($query) use ($empresa) {
            $query->whereHas('quadra', function($q) use ($empresa) {
                $q->where('empresa_id', $empresa->id);
            });
        })->with('user')->paginate(10);

        return view('admin.clientes.index', compact('clientes', 'empresa'));
    }

    public function create()
    {
        $empresa = auth()->user()->admin->empresa;
        return view('admin.clientes.create', compact('empresa'));
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

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        // Verificar se o cliente tem reservas na empresa do admin
        $user = auth()->user();
        $empresa = $user->admin->empresa;
        
        $temReservas = $cliente->reservas()
            ->whereHas('quadra', function($query) use ($empresa) {
                $query->where('empresa_id', $empresa->id);
            })->exists();

        if (!$temReservas) {
            abort(403, 'Cliente não pertence a esta empresa.');
        }

        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;
        
        $temReservas = $cliente->reservas()
            ->whereHas('quadra', function($query) use ($empresa) {
                $query->where('empresa_id', $empresa->id);
            })->exists();

        if (!$temReservas) {
            abort(403, 'Cliente não pertence a esta empresa.');
        }

        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;
        
        $temReservas = $cliente->reservas()
            ->whereHas('quadra', function($query) use ($empresa) {
                $query->where('empresa_id', $empresa->id);
            })->exists();

        if (!$temReservas) {
            abort(403, 'Cliente não pertence a esta empresa.');
        }

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

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;
        
        $temReservas = $cliente->reservas()
            ->whereHas('quadra', function($query) use ($empresa) {
                $query->where('empresa_id', $empresa->id);
            })->exists();

        if (!$temReservas) {
            abort(403, 'Cliente não pertence a esta empresa.');
        }

        $user = $cliente->user;
        $cliente->delete();
        $user->delete();

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $search = $request->get('search');
        $clientes = Cliente::whereHas('reservas', function($query) use ($empresa) {
            $query->whereHas('quadra', function($q) use ($empresa) {
                $q->where('empresa_id', $empresa->id);
            });
        })->where(function($query) use ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('cpf', 'like', "%{$search}%");
        })->with('user')
          ->paginate(10);

        return view('admin.clientes.index', compact('clientes'));
    }
}