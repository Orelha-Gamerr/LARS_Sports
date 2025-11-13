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
                'nome' => 'Arena Sports Center',
                'cnpj' => '12.345.678/0001-90',
                'telefone' => '(11) 3333-4444',
                'email' => 'contato@arenasports.com',
                'endereco' => 'Av. Paulista, 1000 - São Paulo, SP',
                'responsavel' => 'João Silva',
                'ativa' => true,
            ],
            [
                'nome' => 'Clube dos Atletas',
                'cnpj' => '98.765.432/0001-10',
                'telefone' => '(11) 2222-3333',
                'email' => 'contato@clubedosatletas.com',
                'endereco' => 'Rua Augusta, 500 - São Paulo, SP',
                'responsavel' => 'Maria Santos',
                'ativa' => true,
            ],
            [
                'nome' => 'Complexo Vôlei Praia',
                'cnpj' => '11.222.333/0001-44',
                'telefone' => '(21) 4444-5555',
                'email' => 'contato@voleipraia.com',
                'endereco' => 'Praia de Ipanema, 200 - Rio de Janeiro, RJ',
                'responsavel' => 'Carlos Oliveira',
                'ativa' => true,
            ]
        ];

        foreach ($empresas as $empresa) {
            Empresa::create($empresa);
        }

        $this->command->info('✅ ' . count($empresas) . ' empresas criadas com sucesso!');
    }
}