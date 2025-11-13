<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'name' => 'João Silva',
                'email' => 'joao.silva@email.com',
                'password' => 'password',
                'telefone' => '(11) 98888-7777',
                'cpf' => '123.456.789-00',
                'data_nascimento' => '1990-05-15',
                'endereco' => 'Rua das Flores, 123 - São Paulo, SP',
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'password' => 'password',
                'telefone' => '(11) 97777-6666',
                'cpf' => '987.654.321-00',
                'data_nascimento' => '1985-08-22',
                'endereco' => 'Av. Paulista, 500 - São Paulo, SP',
            ],
            [
                'name' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@email.com',
                'password' => 'password',
                'telefone' => '(11) 96666-5555',
                'cpf' => '456.789.123-00',
                'data_nascimento' => '1992-12-10',
                'endereco' => 'Rua Augusta, 789 - São Paulo, SP',
            ],
            [
                'name' => 'Ana Costa',
                'email' => 'ana.costa@email.com',
                'password' => 'password',
                'telefone' => '(21) 95555-4444',
                'cpf' => '789.123.456-00',
                'data_nascimento' => '1988-03-25',
                'endereco' => 'Praia de Copacabana, 200 - Rio de Janeiro, RJ',
            ]
        ];

        foreach ($clientes as $clienteData) {
            // Verificar se o usuário já existe
            if (!User::where('email', $clienteData['email'])->exists()) {
                $user = User::create([
                    'name' => $clienteData['name'],
                    'email' => $clienteData['email'],
                    'password' => Hash::make($clienteData['password']),
                ]);

                Cliente::create([
                    'user_id' => $user->id,
                    'telefone' => $clienteData['telefone'],
                    'cpf' => $clienteData['cpf'],
                    'data_nascimento' => $clienteData['data_nascimento'],
                    'endereco' => $clienteData['endereco'],
                ]);

                $this->command->info("✅ Cliente criado: {$clienteData['email']}");
            } else {
                $this->command->info("⏭️ Cliente já existe: {$clienteData['email']}");
            }
        }

        $this->command->info('✅ Todos os clientes foram processados!');
    }
}