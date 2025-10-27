<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quadra extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nome',
        'tipo',
        'descricao',
        'preco_hora',
        'capacidade',
        'disponivel',
        'imagem'
    ];

    protected $casts = [
        'disponivel' => 'boolean',
        'preco_hora' => 'decimal:2',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function scopeDisponivel($query)
    {
        return $query->where('disponivel', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeDaEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopeComEmpresa($query)
    {
        return $query->with('empresa');
    }
}