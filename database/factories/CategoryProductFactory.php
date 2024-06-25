<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryProductFactory extends Factory
{
    public function definition()
    {
        return [
            'category_id' => Category::factory()->create()->id,
            'product_id' => Product::factory()->create()->id,
            // Add more fields as needed
        ];
    }
}
