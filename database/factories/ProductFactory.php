<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    // Array of coffee drink names
    private static $coffeeDrinks = [
        'Latte',
        'Espresso',
        'Cappuccino',
        'Mocha',
        'Americano',
        'Macchiato',
        'Affogato',
        'Flat White',
        'Irish Coffee',
        'Vienna Coffee',
    ];

    // Static variable to keep track of the current index
    private static $currentIndex = 0;

    public function definition(): array
    {
        // Get the current coffee drink name
        $name = self::$coffeeDrinks[self::$currentIndex];

        // Increment the index and reset if it exceeds the array length
        self::$currentIndex = (self::$currentIndex + 1) % count(self::$coffeeDrinks);

        return [
            'name' => $name,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(0, 50, 100),
            'image' => 'https://picsum.photos/400/300?random=' . rand(1, 1000), // Example placeholder image URL
            'category_id' => 1, // Hard-coded category_id for "Coffee"
        ];
    }
}