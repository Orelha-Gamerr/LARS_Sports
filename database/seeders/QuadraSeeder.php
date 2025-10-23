<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quadra;

class QuadraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quadras = [
            [
                'nome' => 'Quadra Society Principal',
                'tipo' => 'society',
                'descricao' => 'Quadra society oficial com grama sintética',
                'preco_hora' => 180.00,
                'capacidade' => 22,
                'disponivel' => true,
            ],
            [
                'nome' => 'Quadra Futsal',
                'tipo' => 'futsal',
                'descricao' => 'Quadra de futsal profissional',
                'preco_hora' => 120.00,
                'capacidade' => 14,
                'disponivel' => true,
            ],
            [
                'nome' => 'Quadra Vôlei',
                'tipo' => 'volei',
                'descricao' => 'Quadra de vôlei de praia',
                'preco_hora' => 80.00,
                'capacidade' => 12,
                'disponivel' => true,
            ],
        ];

        foreach ($quadras as $quadra) {
            Quadra::create($quadra);
        }

        Quadra::factory(5)->create();
    }
}
