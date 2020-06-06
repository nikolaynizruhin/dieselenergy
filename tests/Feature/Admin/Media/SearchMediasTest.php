<?php

namespace Tests\Feature\Admin\Media;

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

        $diesel = factory(Image::class)->create(['path' => 'images/dieselpath.jpg', 'created_at' => now()->subDay()]);
        $patrol = factory(Image::class)->create(['path' => 'images/patrolpath.jpg', 'created_at' => now()]);
        $waterPump = factory(Image::class)->create(['path' => 'images/waterpump.jpg']);

        $product = factory(Product::class)->create();

        $product->images()->attach([$diesel->id, $patrol->id]);

        $this->actingAs($user)
            ->get(route('admin.products.show', [
                'product' => $product,
                'search' => 'path',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$patrol->path, $diesel->path])
            ->assertDontSee($waterPump->path);
    }
}
