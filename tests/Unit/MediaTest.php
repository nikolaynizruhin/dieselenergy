<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\Media;
use App\Models\Product;
use Tests\TestCase;

class MediaTest extends TestCase
{
    /** @test */
    public function it_has_product(): void
    {
        $media = Media::factory()
            ->forProduct()
            ->create();

        $this->assertInstanceOf(Product::class, $media->product);
    }

    /** @test */
    public function it_has_image(): void
    {
        $media = Media::factory()
            ->forImage()
            ->create();

        $this->assertInstanceOf(Image::class, $media->image);
    }

    /** @test */
    public function it_can_be_marked_as_default(): void
    {
        $media = Media::factory()
            ->regular()
            ->forImage()
            ->create();

        $media->markAsDefault();

        $this->assertTrue($media->is_default);
    }
}
