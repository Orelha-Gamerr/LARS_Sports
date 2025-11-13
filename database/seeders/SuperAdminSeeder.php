<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminEmail = 'superadmin@reservequadras.com';
        
        if (!User::where('email', $superAdminEmail)->exists()) {
            $superAdminUser = User::create([
                'name' => 'Super Admin',
                'email' => $superAdminEmail,
                'password' => Hash::make('password'),
            ]);

            SuperAdmin::create([
                'user_id' => $superAdminUser->id,
                'telefone' => '(11) 99999-9999',
            ]);

            $this->command->info('Super Admin criado com sucesso!');
            $this->command->info('Email: superadmin@reservequadras.com');
            $this->command->info('Password: password');
        } else {
            $this->command->info('Super Admin já existe!');
        }
    }
}