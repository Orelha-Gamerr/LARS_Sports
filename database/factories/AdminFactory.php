<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Empresa;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $empresas = Empresa::pluck('id')->toArray();
        
        return [
            'user_id' => User::factory(),
            'empresa_id' => $this->faker->optional(0.7)->randomElement($empresas), // 70% com empresa, 30% superadmin
            'nivel_acesso' => $this->faker->randomElement(['superadmin', 'admin', 'operador']),
        ];
    }
}
