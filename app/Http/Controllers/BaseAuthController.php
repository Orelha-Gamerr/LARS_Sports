<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BaseAuthController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return redirect()->route('login')->withErrors('Você precisa estar logado.');
            }

            $this->user = Auth::user();

            // Caso o controller tenha a função checkRole, ela será usada para validar o tipo de usuário
            if (method_exists($this, 'checkRole')) {
                $allowed = $this->checkRole($this->user);
                if ($allowed !== true) {
                    return $allowed;
                }
            }

            return $next($request);
        });
    }
}
