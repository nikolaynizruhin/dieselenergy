<?php

namespace Tests\Unit\Cart;

use App\Cart\Item;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_total()
    {
        $currency = Currency::factory()->state(['rate' => 30.0000]);
        $brand = Brand::factory()->for($currency);
        $product = Product::factory()
            ->for($brand)
            ->withDefaultImage()
            ->create(['price' => 10000]);

        $item = new Item($product, 2);

        $this->assertEquals(6000, $item->total());
    }
}
