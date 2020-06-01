<?php

namespace Tests\Unit;

use App\Image;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
