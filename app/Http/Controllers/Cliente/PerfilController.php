<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
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

        // Validação
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:clientes,cpf,' . $cliente->id,
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Iniciar transação para garantir consistência
            \DB::transaction(function () use ($user, $cliente, $validated, $request) {
                // Atualizar usuário
                $user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ]);

                // Upload da foto se fornecida
                $fotoPath = $cliente->foto; // Manter foto atual por padrão
                
                if ($request->hasFile('foto')) {
                    // Deletar foto antiga se existir
                    if ($cliente->foto && Storage::disk('public')->exists($cliente->foto)) {
                        Storage::disk('public')->delete($cliente->foto);
                    }
                    
                    $fotoPath = $request->file('foto')->store('clientes', 'public');
                }

                // Atualizar cliente
                $cliente->update([
                    'telefone' => $validated['telefone'],
                    'cpf' => $validated['cpf'],
                    'data_nascimento' => $validated['data_nascimento'],
                    'endereco' => $validated['endereco'],
                    'foto' => $fotoPath,
                ]);
            });

            return redirect()->route('cliente.perfil.show')->with('success', 'Perfil atualizado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar perfil: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao atualizar perfil. Tente novamente.');
        }
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

    public function deleteFoto(Request $request)
    {
        $cliente = auth()->user()->cliente;

        if ($cliente->foto && Storage::disk('public')->exists($cliente->foto)) {
            Storage::disk('public')->delete($cliente->foto);
        }

        $cliente->update(['foto' => null]);

        return redirect()->route('cliente.perfil.edit')->with('success', 'Foto removida com sucesso!');
    }
}