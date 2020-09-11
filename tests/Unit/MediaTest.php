<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_product()
    {
        $product = Product::factory()->create();
        $media = Media::factory()->create(['product_id' => $product->id]);

        $this->assertInstanceOf(Product::class, $media->product);
        $this->assertTrue($media->product->is($product));
    }

    /** @test */
    public function it_has_image()
    {
        $image = Image::factory()->create();
        $media = Media::factory()->create(['image_id' => $image->id]);

        $this->assertInstanceOf(Image::class, $media->image);
        $this->assertTrue($media->image->is($image));
    }
}
