<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::factory(20)->create()->each(function ($order) {
            OrderItem::factory(random_int(3, 10))->create(['order_id' => $order->id]);
        });
    }
}
