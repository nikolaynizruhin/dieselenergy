<?php

namespace Tests\Unit;

use App\Image;
use App\Media;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_product()
    {
        $product = factory(Product::class)->create();
        $media = factory(Media::class)->create(['product_id' => $product->id]);

        $this->assertInstanceOf(Product::class, $media->product);
        $this->assertTrue($media->product->is($product));
    }

    /** @test */
    public function it_has_image()
    {
        $image = factory(Image::class)->create();
        $media = factory(Media::class)->create(['image_id' => $image->id]);

        $this->assertInstanceOf(Image::class, $media->image);
        $this->assertTrue($media->image->is($image));
    }
}
