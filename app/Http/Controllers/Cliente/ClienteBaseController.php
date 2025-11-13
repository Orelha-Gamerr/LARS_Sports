<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\BaseAuthController;

class ClienteBaseController extends BaseAuthController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            if (!$this->user->cliente) {
                abort(403, 'Acesso negado. Apenas clientes podem acessar esta área.');
            }

            return $next($request);
        });
    }
}
