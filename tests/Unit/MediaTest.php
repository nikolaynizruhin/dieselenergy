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
        $media = Media::factory()
            ->for(Product::factory())
            ->create();

        $this->assertInstanceOf(Product::class, $media->product);
    }

    /** @test */
    public function it_has_image()
    {
        $media = Media::factory()
            ->for(Image::factory())
            ->create();

        $this->assertInstanceOf(Image::class, $media->image);
    }
}
