<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\Media;
use App\Models\Product;
use Tests\TestCase;

class MediaTest extends TestCase
{
    /** @test */
    public function it_has_product()
    {
        $media = Media::factory()
            ->forProduct()
            ->create();

        $this->assertInstanceOf(Product::class, $media->product);
    }

    /** @test */
    public function it_has_image()
    {
        $media = Media::factory()
            ->forImage()
            ->create();

        $this->assertInstanceOf(Image::class, $media->image);
    }
}
