<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'telefone',
        'cpf',
        'data_nascimento',
        'endereco',
        'foto'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    // Acessor para nome através do user
    public function getNomeAttribute()
    {
        return $this->user->name;
    }

    // Acessor para email através do user
    public function getEmailAttribute()
    {
        return $this->user->email;
    }
     public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/avatar-default.png');
    }
}