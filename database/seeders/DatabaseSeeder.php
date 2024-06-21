<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Database\Factories\CategoryFactory;
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
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        User::create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => 'password',
            'role' => User::ROLE_SELLER,
        ]);

        User::create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
            'password' => 'password',
            'role' => User::ROLE_BUYER,
        ]);

        $this->call(CategorySeeder::class);

        $this->call(ProductSeeder::class);
    }
}
