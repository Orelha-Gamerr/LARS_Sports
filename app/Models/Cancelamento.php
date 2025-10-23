<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancelamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserva_id',
        'motivo',
        'tipo',
        'data_cancelamento',
        'valor_estornado'
    ];

    protected $casts = [
        'data_cancelamento' => 'datetime',
        'valor_estornado' => 'decimal:2',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}