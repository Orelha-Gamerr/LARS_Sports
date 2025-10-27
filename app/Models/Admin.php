<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'empresa_id',
        'nivel_acesso'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function isSuperAdmin()
    {
        return is_null($this->empresa_id);
    }

    public function isAdminEmpresa()
    {
        return !is_null($this->empresa_id);
    }

    public function getTipoAdminAttribute()
    {
        return $this->isSuperAdmin() ? 'superadmin' : 'admin_empresa';
    }

    public function getNomeEmpresaAttribute()
    {
        return $this->empresa ? $this->empresa->nome : 'Sistema';
    }
}