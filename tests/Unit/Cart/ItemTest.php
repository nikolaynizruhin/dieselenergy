<?php

namespace Tests\Unit\Cart;

use App\Support\CartItem;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\Product;
use Tests\TestCase;

class ItemTest extends TestCase
{
    /** @test */
    public function it_can_get_total()
    {
        $currency = Currency::factory()->state(['rate' => 30.0000]);
        $brand = Brand::factory()->for($currency);
        $product = Product::factory()
            ->for($brand)
            ->withDefaultImage()
            ->create(['price' => 10000]);

        $item = new CartItem($product, 2);

        $this->assertEquals(600000, $item->total());
    }
}
