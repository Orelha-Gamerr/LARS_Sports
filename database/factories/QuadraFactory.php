<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Empresa;

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
        $empresas = Empresa::pluck('id')->toArray();
        
        return [
            'empresa_id' => $this->faker->randomElement($empresas),
            'nome' => 'Quadra ' . $this->faker->word() . ' ' . $this->faker->randomElement(['A', 'B', 'C', 'Principal', 'Secundária']),
            'tipo' => $this->faker->randomElement($tipos),
            'descricao' => $this->faker->sentence(),
            'preco_hora' => $this->faker->randomFloat(2, 50, 200),
            'capacidade' => $this->faker->numberBetween(5, 20),
            'disponivel' => $this->faker->boolean(90),
            'imagem' => $this->faker->imageUrl(400, 300, 'sports'),
        ];
    }
}
