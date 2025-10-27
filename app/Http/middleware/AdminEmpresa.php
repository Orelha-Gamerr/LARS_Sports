<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminEmpresa
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdminEmpresa()) {
            abort(403, 'Acesso não autorizado. Apenas Administradores de Empresa.');
        }

        return $next($request);
    }
}