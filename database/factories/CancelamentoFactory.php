<?php

namespace Database\Factories;
use App\Models\Reserva;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cancelamento>
 */
class CancelamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reserva_id' => Reserva::factory(),
            'motivo' => $this->faker->sentence(),
            'tipo' => $this->faker->randomElement(['cliente', 'admin', 'sistema']),
            'data_cancelamento' => $this->faker->dateTime(),
            'valor_estornado' => $this->faker->optional()->randomFloat(2, 0, 200),
        ];
    }
}
