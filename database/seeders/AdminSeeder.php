<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Empresa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $empresas = Empresa::all();

        $admins = [
            [
                'name' => 'Admin Arena Sports',
                'email' => 'admin@arenasports.com',
                'password' => 'password',
                'empresa_id' => $empresas[0]->id, // Arena Sports Center
            ],
            [
                'name' => 'Admin Clube Atletas',
                'email' => 'admin@clubedosatletas.com',
                'password' => 'password',
                'empresa_id' => $empresas[1]->id, // Clube dos Atletas
            ],
            [
                'name' => 'Admin Vôlei Praia',
                'email' => 'admin@voleipraia.com',
                'password' => 'password',
                'empresa_id' => $empresas[2]->id, // Complexo Vôlei Praia
            ]
        ];

        foreach ($admins as $adminData) {
            // Verificar se o usuário já existe
            if (!User::where('email', $adminData['email'])->exists()) {
                $user = User::create([
                    'name' => $adminData['name'],
                    'email' => $adminData['email'],
                    'password' => Hash::make($adminData['password']),
                ]);

                Admin::create([
                    'user_id' => $user->id,
                    'empresa_id' => $adminData['empresa_id'],
                ]);

                $this->command->info("✅ Admin criado: {$adminData['email']}");
            } else {
                $this->command->info("⏭️ Admin já existe: {$adminData['email']}");
            }
        }

        $this->command->info('✅ Todos os admins de empresa foram processados!');
    }
}