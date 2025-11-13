<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->isSuperAdmin()) {
                return redirect()->route('super-admin.dashboard');
            } elseif ($user->isAdminEmpresa()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('cliente.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => 'required|in:cliente,admin,superadmin', 
            'telefone' => 'required_if:tipo,cliente|string|max:20',
            'cpf' => 'required_if:tipo,cliente|string|max:14|unique:clientes,cpf',
            'empresa_id' => 'required_if:tipo,admin|exists:empresas,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->tipo === 'cliente') {
            Cliente::create([
                'user_id' => $user->id,
                'telefone' => $request->telefone,
                'cpf' => $request->cpf,
                'data_nascimento' => $request->data_nascimento,
                'endereco' => $request->endereco,
            ]);
        } elseif ($request->tipo === 'admin') {
            Admin::create([
                'user_id' => $user->id,
                'empresa_id' => $request->empresa_id,
            ]);
        } elseif ($request->tipo === 'superadmin') {
            // Apenas super admins existentes podem criar novos super admins
            if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
                abort(403, 'Apenas super administradores podem criar novos super administradores.');
            }
            SuperAdmin::create([
                'user_id' => $user->id,
                'telefone' => $request->telefone,
            ]);
        }

        Auth::login($user);

        return redirect()->route('home');
    }
}