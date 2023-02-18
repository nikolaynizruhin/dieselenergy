<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Currency;
use App\Models\Product;
use App\Support\CartItem;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    /** @test */
    public function it_can_get_total(): void
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
