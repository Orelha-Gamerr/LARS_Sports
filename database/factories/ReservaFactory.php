<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;
use App\Models\Horario;
use App\Models\Quadra;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'quadra_id' => Quadra::factory(),
            'horario_id' => Horario::factory(),
            'data_reserva' => $this->faker->dateTimeBetween('now', '+30 days'),
            'status' => $this->faker->randomElement(['pendente', 'confirmado', 'cancelado', 'finalizado']),
            'valor_total' => $this->faker->randomFloat(2, 50, 200),
            'observacoes' => $this->faker->optional()->sentence(),
        ];
    }
}
