<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAuthController;

class AdminBaseController extends BaseAuthController
{
    protected $empresa;

    protected function checkRole($user)
    {
        if (!$user->admin) {
            abort(403, 'Acesso negado. Somente administradores podem acessar esta área.');
        }

        $this->empresa = $user->admin->empresa ?? null;

        if (!$this->empresa) {
            abort(403, 'Administrador não possui empresa associada.');
        }

        return true;
    }
}
