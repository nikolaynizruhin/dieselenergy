<?php

namespace Tests\Unit\Cart;

use App\Cart\Item;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_total()
    {
        $product = factory(Product::class)->create(['price' => 100]);

        $item = new Item($product, 2);

        $this->assertEquals(200, $item->total());
    }
}
