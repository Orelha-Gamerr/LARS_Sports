<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Quadra;
use Illuminate\Database\Seeder;

class QuadraSeeder extends Seeder
{
    public function run(): void
    {
        $empresas = Empresa::all();

        $quadras = [
            [
                'empresa_id' => $empresas[0]->id,
                'nome' => 'Quadra Society Principal',
                'tipo' => 'society',
                'descricao' => 'Quadra society oficial com grama sintética de última geração',
                'preco_hora' => 180.00,
                'capacidade' => 22,
                'disponivel' => true,
            ],
            [
                'empresa_id' => $empresas[0]->id,
                'nome' => 'Quadra Futsal Profissional',
                'tipo' => 'futsal',
                'descricao' => 'Quadra de futsal com piso emborrachado profissional',
                'preco_hora' => 120.00,
                'capacidade' => 14,
                'disponivel' => true,
            ],
            [
                'empresa_id' => $empresas[1]->id,
                'nome' => 'Quadra de Vôlei de Praia',
                'tipo' => 'volei',
                'descricao' => 'Quadra de vôlei de praia com areia especial',
                'preco_hora' => 80.00,
                'capacidade' => 12,
                'disponivel' => true,
            ],
            [
                'empresa_id' => $empresas[1]->id,
                'nome' => 'Quadra de Basquete',
                'tipo' => 'basquete',
                'descricao' => 'Quadra de basquete oficial com tabelas profissionais',
                'preco_hora' => 90.00,
                'capacidade' => 10,
                'disponivel' => true,
            ],
            [
                'empresa_id' => $empresas[2]->id,
                'nome' => 'Quadra de Tênis',
                'tipo' => 'tenis',
                'descricao' => 'Quadra de tênis com piso rápido',
                'preco_hora' => 150.00,
                'capacidade' => 4,
                'disponivel' => true,
            ],
            [
                'empresa_id' => $empresas[2]->id,
                'nome' => 'Quadra Society II',
                'tipo' => 'society',
                'descricao' => 'Quadra society secundária com iluminação noturna',
                'preco_hora' => 160.00,
                'capacidade' => 20,
                'disponivel' => true,
            ],
        ];

        foreach ($quadras as $quadra) {
            Quadra::create($quadra);
        }

        Quadra::factory(10)->create([
            'empresa_id' => $empresas->random()->id
        ]);
    }
}