<?php

namespace Database\Factories;
use App\Models\Reserva;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pagamento>
 */
class PagamentoFactory extends Factory
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
            'valor' => $this->faker->randomFloat(2, 50, 200),
            'metodo' => $this->faker->randomElement(['pix', 'cartao_credito', 'cartao_debito', 'dinheiro']),
            'status' => $this->faker->randomElement(['pendente', 'pago', 'cancelado', 'estornado']),
            'codigo_transacao' => $this->faker->uuid(),
            'data_pagamento' => $this->faker->optional()->dateTime(),
        ];
    }
}
