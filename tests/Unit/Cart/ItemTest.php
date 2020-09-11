<?php

namespace Tests\Unit\Cart;

use App\Cart\Item;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_total()
    {
        $product = Product::factory()
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->create(['price' => 100]);

        $item = new Item($product, 2);

        $this->assertEquals(200, $item->total());
    }
}
