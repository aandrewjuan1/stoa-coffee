<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;


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
            'name' => 'Customer1',
            'email' => 'buyer1@example.com',
            'password' => 'password',
            'is_admin' => false
        ]);

        User::create([
            'name' => 'Customer2',
            'email' => 'buyer2@example.com',
            'password' => 'password',
            'is_admin' => false
        ]);

        User::create([
            'name' => 'Customer3',
            'email' => 'buyer3@example.com',
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

        // Generate orders and order items
        Order::factory(20)->create()->each(function ($order) {
            OrderItem::factory(random_int(3,10))->create(['order_id' => $order->id]);
        });
    }
}
