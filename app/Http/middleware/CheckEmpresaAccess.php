<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEmpresaAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if ($user->isAdminEmpresa()) {
            $empresaId = $user->empresa->id;
            
            if ($request->route('quadra')) {
                $quadra = $request->route('quadra');
                if ($quadra->empresa_id !== $empresaId) {
                    abort(403, 'Acesso não autorizado a esta quadra.');
                }
            }
            
            if ($request->route('horario')) {
                $horario = $request->route('horario');
                if ($horario->quadra->empresa_id !== $empresaId) {
                    abort(403, 'Acesso não autorizado a este horário.');
                }
            }
        }
        
        return $next($request);
    }
}