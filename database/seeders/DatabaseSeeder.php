<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'is_admin' => true
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'buyer@example.com',
            'password' => 'password',
            'is_admin' => false
        ]);

        $categories = Category::factory(5)->create();
        $products = Product::factory(20)->create();

        // Seed pivot table `category_product`
        foreach ($products as $product) {
            $product->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
