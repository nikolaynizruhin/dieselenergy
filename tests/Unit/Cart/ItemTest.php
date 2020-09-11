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
        $image = Image::factory()->create();
        $product = Product::factory()->create(['price' => 100]);

        $product->images()->attach($image, ['is_default' => 1]);

        $item = new Item($product, 2);

        $this->assertEquals(200, $item->total());
    }
}
