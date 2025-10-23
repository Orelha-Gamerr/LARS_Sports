<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Horario;
use App\Models\Quadra;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quadras = Quadra::all();

        foreach ($quadras as $quadra) {
            for ($hora = 8; $hora <= 22; $hora++) {
                Horario::create([
                    'quadra_id' => $quadra->id,
                    'horario_inicio' => sprintf('%02d:00:00', $hora),
                    'horario_fim' => sprintf('%02d:00:00', $hora + 1),
                    'disponivel' => true,
                ]);
            }
        }
    }
}
