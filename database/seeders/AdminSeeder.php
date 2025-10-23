<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Criar admin principal
        $userAdmin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@quadras.com',
            'password' => Hash::make('password'),
        ]);

        Admin::create([
            'user_id' => $userAdmin->id,
            'nivel_acesso' => 'superadmin',
        ]);

        // Criar mais admins
        Admin::factory(2)->create();
    }
}