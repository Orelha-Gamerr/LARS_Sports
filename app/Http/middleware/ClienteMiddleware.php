<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClienteMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isCliente()) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado. Apenas clientes podem acessar esta área.');
    }
}