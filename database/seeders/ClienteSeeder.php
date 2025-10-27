<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $userCliente = User::create([
            'name' => 'João Cliente',
            'email' => 'cliente@email.com',
            'password' => Hash::make('password'),
        ]);

        Cliente::create([
            'user_id' => $userCliente->id,
            'telefone' => '(11) 99999-9999',
            'cpf' => '123.456.789-00',
            'data_nascimento' => '1990-01-01',
            'endereco' => 'Rua Exemplo, 123',
        ]);

        Cliente::factory(10)->create();
    }
}