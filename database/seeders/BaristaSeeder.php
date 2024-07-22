<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barista;

class BaristaSeeder extends Seeder
{
    public function run(): void
    {
        $barista = User::create([
            'name' => 'Barista',
            'email' => 'barista@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false
        ]);
        Barista::create([
            'user_id' => $barista->id,
        ]);
    }
}
