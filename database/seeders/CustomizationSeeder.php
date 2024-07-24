<?php

namespace Database\Seeders;

use App\Models\CustomizationItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomizationSeeder extends Seeder
{
    public function run(): void
    {
        $customizationTypes = [
            'temperature' => [
                ['input_field' => 'radio_button', 'value' => 'hot', 'price' => 0.00, 'required' => true],
                ['input_field' => 'radio_button', 'value' => 'iced', 'price' => 0.00, 'required' => true],
            ],
            'size' => [
                ['input_field' => 'radio_button', 'value' => '16oz', 'price' => 0.00, 'required' => true],
                ['value' => '22oz', 'price' => 15.00, 'required' => true],
            ],
            'sweetness' => [
                ['input_field' => 'radio_button', 'value' => 'not sweet', 'price' => 0.00, 'required' => true],
                ['input_field' => 'radio_button', 'value' => 'less sweet', 'price' => 0.00, 'required' => true],
                ['input_field' => 'radio_button', 'value' => 'regular sweetness', 'price' => 0.00, 'required' => true],
            ],
            'milk' => [
                ['input_field' => 'radio_button', 'value' => 'whole milk', 'price' => 0.00, 'required' => true],
                ['input_field' => 'radio_button', 'value' => 'non-fat milk', 'price' => 0.00, 'required' => true],
                ['input_field' => 'radio_button', 'value' => 'sub soymilk', 'price' => 20.00, 'required' => true],
                ['input_field' => 'radio_button', 'value' => 'sub coconutmilk', 'price' => 20.00, 'required' => true],
            ],
            'espresso' => [
                ['input_field' => 'check_box', 'value' => 'decaf', 'price' => 0.00, 'required' => false],
                ['input_field' => 'check_box', 'value' => 'add shot', 'price' => 40.00, 'required' => false],
            ],
            'syrup' => [
                ['input_field' => 'check_box', 'value' => 'add vanilla syrup', 'price' => 30.00, 'required' => false],
                ['input_field' => 'check_box', 'value' => 'add caramel syrup', 'price' => 30.00, 'required' => false],
                ['input_field' => 'check_box', 'value' => 'add hazelnut syrup', 'price' => 30.00, 'required' => false],
                ['input_field' => 'check_box', 'value' => 'add salted caramel syrup', 'price' => 30.00, 'required' => false],
            ],
            'special instructions' => [
                ['input_field' => 'text_area', 'required' => false]
            ],
        ];

        $typeIds = [];
        foreach ($customizationTypes as $type => $values) {
            $id = DB::table('customizations')->insertGetId([
                'type' => $type,
                'input_field' => $values[0]['input_field'],
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

        $products = Product::all();
        $customizationItemsIds = CustomizationItem::pluck('id')->toArray();

        foreach ($products as $product) {
            $product->customizations()->sync($typeIds);
            $product->customizationItems()->sync($customizationItemsIds);
        }
    }
}
