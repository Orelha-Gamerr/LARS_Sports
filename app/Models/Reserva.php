<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'quadra_id',
        'horario_id',
        'data_reserva', 
        'status',
        'valor_total',
        'observacoes'
    ];

    protected $casts = [
        'data_reserva' => 'date',
        'valor_total' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function quadra()
    {
        return $this->belongsTo(Quadra::class);
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    public function pagamento()
    {
        return $this->hasOne(Pagamento::class);
    }

    public function cancelamento()
    {
        return $this->hasOne(Cancelamento::class);
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('status', 'confirmado');
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }
}