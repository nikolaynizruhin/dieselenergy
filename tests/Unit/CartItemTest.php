<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Currency;
use App\Models\Product;
use App\Support\CartItem;

it('can get total', function () {
    $currency = Currency::factory()->state(['rate' => 30.0000]);
    $brand = Brand::factory()->for($currency);
    $product = Product::factory()
        ->for($brand)
        ->withDefaultImage()
        ->create(['price' => 10000]);

    $item = new CartItem($product, 2);

    $this->assertEquals(600000, $item->total());
});
