<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\BaseAuthController;

class SuperAdminBaseController extends BaseAuthController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            if (!$this->user->superadmin) {
                abort(403, 'Acesso negado. Apenas superadministradores podem acessar esta área.');
            }

            return $next($request);
        });
    }
}
