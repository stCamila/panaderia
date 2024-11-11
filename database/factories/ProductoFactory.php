<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->sentence(2),
            'descripcion' => $this->faker->text(60),
            'precio' => $this->faker->randomFloat(2, 5, 100),
            'stock' => $this->faker->numberBetween(1,50),
            'image' => '/img/example.png'
        ];
    }
}
