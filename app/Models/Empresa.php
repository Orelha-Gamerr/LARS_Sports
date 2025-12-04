<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'telefone',
        'email',
        'endereco',
        'responsavel',
        'logo',
        'ativa'
    ];

    public function quadras()
    {
        return $this->hasMany(Quadra::class);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function superAdmins()
    {
        return $this->belongsToMany(SuperAdmin::class);
    }

    public function reservas()
    {
        return $this->hasManyThrough(Reserva::class, Quadra::class);
    }

    public function horarios()
    {
        return $this->hasManyThrough(Horario::class, Quadra::class);
    }

    public function scopeAtiva($query)
    {
        return $query->where('ativa', true);
    }

    public function getQuadrasAtivasAttribute()
    {
        return $this->quadras()->where('disponivel', true)->count();
    }

    // Faturamento mensal (exemplo)
    public function getFaturamentoMensalAttribute()
    {
        return $this->reservas()
            ->where('status', 'confirmado')
            ->whereMonth('created_at', now()->month)
            ->sum('valor_total');
    }
}