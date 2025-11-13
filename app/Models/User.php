<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function superAdmin()
    {
        return $this->hasOne(SuperAdmin::class);
    }

    public function isAdmin()
    {
        return $this->admin !== null;
    }

    public function isSuperAdmin()
    {
        return $this->superAdmin !== null;
    }

    public function isAdminEmpresa()
    {
        return $this->admin !== null;
    }

    public function isCliente()
    {
        return $this->cliente !== null;
    }

    public function getTipoUsuarioAttribute()
    {
        if ($this->isSuperAdmin()) {
            return 'superadmin';
        } elseif ($this->isAdminEmpresa()) {
            return 'admin_empresa';
        } elseif ($this->isCliente()) {
            return 'cliente';
        }
        return 'usuario';
    }

    public function getEmpresaAttribute()
    {
        if ($this->isAdminEmpresa()) {
            return $this->admin->empresa;
        }
        return null;
    }

    public function scopeClientes($query)
    {
        return $query->whereHas('cliente');
    }

    public function scopeAdmins($query)
    {
        return $query->whereHas('admin');
    }

    public function scopeSuperAdmins($query)
    {
        return $query->whereHas('superAdmin');
    }
}