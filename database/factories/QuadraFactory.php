<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quadra>
 */
class QuadraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos = ['society', 'futsal', 'volei', 'basquete', 'tenis'];
        
        return [
            'nome' => 'Quadra ' . $this->faker->word(),
            'tipo' => $this->faker->randomElement($tipos),
            'descricao' => $this->faker->sentence(),
            'preco_hora' => $this->faker->randomFloat(2, 50, 200),
            'capacidade' => $this->faker->numberBetween(5, 20),
            'disponivel' => $this->faker->boolean(90),
            'imagem' => $this->faker->imageUrl(400, 300, 'sports'),
        ];
    }
}
