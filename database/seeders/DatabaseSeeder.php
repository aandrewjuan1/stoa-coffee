<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Buyer;
use App\Models\Barista;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true
        ]);

        // Seed customers with buyers
        $customer1 = User::create([
            'name' => 'Customer1',
            'email' => 'buyer1@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false
        ]);
        Buyer::create([
            'user_id' => $customer1->id,
            'delivery_address' => '123 Main St, City1',
            'phone_number' => '123-456-7890',
            'feedback' => 'Good customer'
        ]);

        $customer2 = User::create([
            'name' => 'Customer2',
            'email' => 'buyer2@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false
        ]);
        Buyer::create([
            'user_id' => $customer2->id,
            'delivery_address' => '456 Oak Ave, City2',
            'phone_number' => '987-654-3210',
            'feedback' => 'Awesome buyer'
        ]);

        // Seed barista with barista profile
        $barista = User::create([
            'name' => 'Barista',
            'email' => 'barista@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false
        ]);
        Barista::create([
            'user_id' => $barista->id,
        ]);

        // Seed categories and products
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
            OrderItem::factory(random_int(3, 10))->create(['order_id' => $order->id]);
        });
    }
}
