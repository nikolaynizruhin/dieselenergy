<?php

namespace Tests\Unit\Cart;

use App\Cart\Item;
use App\Image;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_total()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create(['price' => 100]);

        $product->images()->attach($image, ['is_default' => 1]);

        $item = new Item($product, 2);

        $this->assertEquals(200, $item->total());
    }
}
