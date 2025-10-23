<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserva_id',
        'valor',
        'metodo',
        'status',
        'codigo_transacao',
        'data_pagamento'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_pagamento' => 'datetime',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function scopePagos($query)
    {
        return $query->where('status', 'pago');
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }
}