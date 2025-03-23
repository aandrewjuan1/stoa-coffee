<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique->word(),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(0, 50, 100),
            'quantity' => $this->faker->randomDigitNotZero(),
            'image' => 'https://picsum.photos/400/300?random=' . rand(1, 1000), 
        ];
    }
}
