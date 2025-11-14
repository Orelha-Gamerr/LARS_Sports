<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('public.home');
    }
    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string',
        ]);


        return redirect()->route('contact')->with('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
    }
}