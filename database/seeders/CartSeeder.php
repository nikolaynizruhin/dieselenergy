<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cart::factory()
            ->count(10)
            ->sequence(fn ($sequence) => ['product_id' => Product::all()->random()])
            ->create();
    }
}
