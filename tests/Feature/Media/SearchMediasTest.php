<?php

namespace Tests\Feature\Media;

use App\Image;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchMediasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_media()
    {
        $user = factory(User::class)->create();

        $diesel = factory(Image::class)->create();
        $patrol = factory(Image::class)->create();

        $product = factory(Product::class)->create();

        $product->images()->attach([$diesel->id, $patrol->id]);

        $this->actingAs($user)
            ->get(route('products.show', [
                'product' => $product,
                'search' => $diesel->path,
            ]))->assertSuccessful()
            ->assertSee($diesel->path)
            ->assertDontSee($patrol->path);
    }
}
