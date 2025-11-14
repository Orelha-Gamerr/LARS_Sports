<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteQuadraController extends Controller
{
    public function index()
    {
        return view('cliente.quadras.index');
    }

    public function show($id)
    {
        return view('cliente.quadras.show', compact('id'));
    }

    public function search(Request $request)
    {
        return view('cliente.quadras.index');
    }
}