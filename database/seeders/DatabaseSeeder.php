<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true
        ]);

        $this->call([
            BuyerSeeder::class,
            BaristaSeeder::class,
            CategoryProductSeeder::class,
            CustomizationSeeder::class,
        ]);
    }
}
