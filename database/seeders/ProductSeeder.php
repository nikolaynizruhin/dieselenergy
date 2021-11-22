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
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->count(20)
            ->sequence(fn ($sequence) => [
                'brand_id' => Brand::all()->random(),
                'category_id' => Category::all()->random(),
            ])->withDefaultImage()
            ->create();
    }
}
