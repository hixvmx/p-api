<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationOption;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create simple products
        Product::factory()->count(10)->create(['type' => 'simple']);

        // create variable products
        Product::factory()->count(5)->create(['type' => 'variable'])
            ->each(function ($product) {
                // 2 variations for each product
                $variations = [['name' => 'Size'],['name' => 'Color']];

                foreach ($variations as $variationData) {
                    $variation = $product->variations()->create($variationData);

                    // 3 options per variation
                    if ($variation->name === 'Size') {
                        $options = [
                            ['name' => 'Small', 'price' => rand(5, 20)],
                            ['name' => 'Medium', 'price' => rand(10, 25)],
                            ['name' => 'Large', 'price' => rand(15, 30)],
                        ];
                    } else { // Color
                        $options = [
                            ['name' => 'Red'],
                            ['name' => 'Blue'],
                            ['name' => 'Green'],
                        ];
                    }

                    $variation->options()->createMany($options);
                }
            });
    }
}
