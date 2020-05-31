<?php

namespace Tests\Unit;

use App\Image;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_products()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $image->products()->attach($product);

        $this->assertTrue($image->products->contains($product));
        $this->assertInstanceOf(Collection::class, $image->products);
    }
}
