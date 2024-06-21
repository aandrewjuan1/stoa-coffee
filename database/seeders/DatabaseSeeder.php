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

        $this->call(CategorySeeder::class);

        $this->call(ProductSeeder::class);
    }
}
