<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quadra;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Horario>
 */
class HorarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     public function definition(): array
    {
        $horarioInicio = $this->faker->time('H:00:00');
        $horarioFim = date('H:00:00', strtotime($horarioInicio) + 3600);
        
        return [
            'quadra_id' => Quadra::factory(),
            'horario_inicio' => $horarioInicio,
            'horario_fim' => $horarioFim,
            'disponivel' => $this->faker->boolean(80),
        ];
    }
}
