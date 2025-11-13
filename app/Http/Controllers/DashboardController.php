<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard');
        } elseif ($user->isAdminEmpresa()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isCliente()) {
            return redirect()->route('cliente.dashboard');
        }
        
        return redirect()->route('login');
    }
}