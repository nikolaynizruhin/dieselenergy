<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()
            ->count(20)
            ->sequence(fn ($sequence) => [
                'brand_id' => Brand::all()->random(),
                'category_id' => Category::all()->random(),
            ])
            ->withDefaultImage()
            ->afterCreating(fn (Product $product) => $product
                ->attributes()
                ->attach(
                    $product->category->attributes->random(),
                    ['value' => rand(1, 10)]
                )
            )
            ->create();
    }
}
