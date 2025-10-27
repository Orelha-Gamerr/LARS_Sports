<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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

    public function isAdmin()
    {
        return $this->admin !== null;
    }

    public function isSuperAdmin()
    {
        return $this->admin && $this->admin->isSuperAdmin();
    }

    public function isAdminEmpresa()
    {
        return $this->admin && $this->admin->isAdminEmpresa();
    }

    public function isCliente()
    {
        return $this->cliente !== null;
    }

    // REMOVER o accessor empresa() que estava causando problemas
    // Em vez disso, acesse através de $user->admin->empresa

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

    // Escopos
    public function scopeClientes($query)
    {
        return $query->whereHas('cliente');
    }

    public function scopeAdmins($query)
    {
        return $query->whereHas('admin');
    }
}