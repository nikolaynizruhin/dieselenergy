<?php

namespace Tests\Feature\Admin\Media;

use App\Image;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadMediasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_medias()
    {
        $user = factory(User::class)->create();

        $diesel = factory(Image::class)->create(['created_at' => now()->subDay()]);
        $patrol = factory(Image::class)->create(['created_at' => now()]);

        $product = factory(Product::class)->create();

        $product->images()->attach([$diesel->id, $patrol->id]);

        $this->actingAs($user)
            ->get(route('admin.products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('admin.products.show')
            ->assertViewHas('images')
            ->assertSeeInOrder([$patrol->path, $diesel->path]);
    }
}
