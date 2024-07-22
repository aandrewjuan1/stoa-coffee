<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Buyer;

class BuyerSeeder extends Seeder
{
    public function run(): void
    {
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
    }
}
