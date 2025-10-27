<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $empresas = Empresa::all();

        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@larsports.com',
            'password' => Hash::make('password'),
        ]);

        Admin::create([
            'user_id' => $superAdminUser->id,
            'empresa_id' => null,
            'nivel_acesso' => 'superadmin',
        ]);

        $adminEmpresa1 = User::create([
            'name' => 'Admin Empresa 1',
            'email' => 'admin1@empresa.com',
            'password' => Hash::make('password'),
        ]);

        Admin::create([
            'user_id' => $adminEmpresa1->id,
            'empresa_id' => $empresas[0]->id,
            'nivel_acesso' => 'admin',
        ]);

        $adminEmpresa2 = User::create([
            'name' => 'Admin Empresa 2',
            'email' => 'admin2@empresa.com',
            'password' => Hash::make('password'),
        ]);

        Admin::create([
            'user_id' => $adminEmpresa2->id,
            'empresa_id' => $empresas[1]->id,
            'nivel_acesso' => 'admin',
        ]);

        Admin::factory(3)->create([
            'empresa_id' => $empresas->random()->id
        ]);
    }
}