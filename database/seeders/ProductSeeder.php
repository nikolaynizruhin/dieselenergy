<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class ProductSeeder extends Seeder
{
    use WithFaker;

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
            ->hasAttached(
                Attribute::all()->random(),
                ['value' => $this->makeFaker()->randomDigit()],
            )->create();
    }
}
