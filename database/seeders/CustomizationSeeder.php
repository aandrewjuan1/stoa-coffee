<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomizationSeeder extends Seeder
{
    public function run(): void
    {
        $customizationTypes = [
            'temperature' => [
                ['value' => 'hot', 'price' => 0.00, 'required' => true],
                ['value' => 'iced', 'price' => 0.00, 'required' => true],
            ],
            'size' => [
                ['value' => '16oz', 'price' => 0.00, 'required' => true],
                ['value' => '22oz', 'price' => 15.00, 'required' => true],
            ],
            'sweetness' => [
                ['value' => 'not sweet', 'price' => 0.00, 'required' => true],
                ['value' => 'less sweet', 'price' => 0.00, 'required' => true],
                ['value' => 'regular sweetness', 'price' => 0.00, 'required' => true],
            ],
            'milk' => [
                ['value' => 'whole milk', 'price' => 0.00, 'required' => true],
                ['value' => 'non-fat milk', 'price' => 0.00, 'required' => true],
                ['value' => 'sub soymilk', 'price' => 20.00, 'required' => true],
                ['value' => 'sub coconutmilk', 'price' => 20.00, 'required' => true],
            ],
            'espresso' => [
                ['value' => 'decaf', 'price' => 0.00, 'required' => false],
                ['value' => 'add shot', 'price' => 40.00, 'required' => false],
            ],
            'syrup' => [
                ['value' => 'add vanilla syrup', 'price' => 30.00, 'required' => false],
                ['value' => 'add caramel syrup', 'price' => 30.00, 'required' => false],
                ['value' => 'add hazelnut syrup', 'price' => 30.00, 'required' => false],
                ['value' => 'add salted caramel syrup', 'price' => 30.00, 'required' => false],
            ],
            'special instructions' => [
                ['required' => false]
            ],
        ];

        $typeIds = [];
        foreach ($customizationTypes as $type => $values) {
            $id = DB::table('customizations')->insertGetId([
                'type' => $type,
                'required' => $values[0]['required'],
            ]);
            $typeIds[$type] = $id;
        }

        foreach ($customizationTypes as $type => $items) {
            foreach ($items as $item) {
                if (isset($item['value'])) {
                    DB::table('customization_items')->insert([
                        'customization_id' => $typeIds[$type],
                        'value' => strtolower($item['value']),
                        'price' => $item['price'],
                    ]);
                }
            }
        }

        $productsId = DB::table('products')->pluck('id')->toArray();

        foreach ($typeIds as $typeId) {
            foreach ($productsId as $productId) {
                DB::table('customization_product')->insert([
                    'customization_id' => $typeId,
                    'product_id' => $productId,
                ]);
            }
        }

        $customizationItems = DB::table('customization_items')->get();

        foreach ($customizationItems as $item) {
            foreach ($productsId as $productId) {
                DB::table('customization_item_product')->insert([
                    'customization_item_id' => $item->id,
                    'product_id' => $productId,
                ]);
            }
        }
    }
}
