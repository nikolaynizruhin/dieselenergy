<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageTest extends TestCase
{
    /** @test */
    public function it_has_many_products()
    {
        $image = Image::factory()
            ->hasProducts()
            ->create();

        $this->assertInstanceOf(Collection::class, $image->products);
    }

    /** @test */
    public function it_has_many_posts()
    {
        $image = Image::factory()
            ->hasPosts()
            ->create();

        $this->assertInstanceOf(Collection::class, $image->posts);
    }

    /** @test */
    public function it_should_remove_file_after_image_deleted()
    {
        Storage::fake();

        $path = UploadedFile::fake()->image('product.jpg')->store('images');

        $image = Image::create(['path' => $path]);

        Storage::assertExists($path);

        $image->delete();

        Storage::assertMissing($path);
    }
}
