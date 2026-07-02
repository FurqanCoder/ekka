<?php

namespace Database\Seeders;

use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $options = [
        'Size' => [
            'SM', 'S', 'M', 'L', 'XL'
        ],
        'Material' => [
            'Cotton',
            'Wool',
            'Leather'
        ],
        'Color' => [
            'White' => '#ffffff',
            'Black' => '#000000',
            'Blue'  => '#45463a',
            'Pink'  => '#5434aa'
        ]
    ];

    foreach ($options as $optionName => $values) {
        $option = ProductOption::create([
            'name' => $optionName,
        ]);

        foreach ($values as $key => $value) {
            if ($optionName === 'Color') {
                // Associative array: key = color name, value = hex code
                ProductOptionValue::create([
                    'product_option_id' => $option->id,
                    'value'             => $key,
                    'color_code'        => $value,
                ]);
            } else {
                // Indexed array: just a list of values
                ProductOptionValue::create([
                    'product_option_id' => $option->id,
                    'value'             => $value,
                ]);
            }
        }
    }
}

}
