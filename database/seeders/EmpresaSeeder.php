<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        $empresas = [
            [
                'nome' => 'Complexo Esportivo Central',
                'cnpj' => '12.345.678/0001-95',
                'telefone' => '(11) 3333-3333',
                'email' => 'central@complexo.com',
                'endereco' => 'Rua Central, 123 - Centro, São Paulo - SP',
                'responsavel' => 'João Silva',
                'ativa' => true,
            ],
            [
                'nome' => 'Clube dos Atletas',
                'cnpj' => '98.765.432/0001-87',
                'telefone' => '(11) 4444-4444',
                'email' => 'contato@clubedosatletas.com',
                'endereco' => 'Av. dos Esportes, 456 - Bairro Novo, São Paulo - SP',
                'responsavel' => 'Maria Santos',
                'ativa' => true,
            ],
            [
                'nome' => 'Arena Sports',
                'cnpj' => '55.666.777/0001-33',
                'telefone' => '(11) 5555-5555',
                'email' => 'arena@sports.com',
                'endereco' => 'Rua das Arenas, 789 - Zona Leste, São Paulo - SP',
                'responsavel' => 'Carlos Oliveira',
                'ativa' => true,
            ]
        ];

        foreach ($empresas as $empresa) {
            Empresa::create($empresa);
        }
    }
}