<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchMediasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_media()
    {
        $user = User::factory()->create();

        $diesel = Image::factory()->create(['path' => 'images/dieselpath.jpg', 'created_at' => now()->subDay()]);
        $patrol = Image::factory()->create(['path' => 'images/patrolpath.jpg', 'created_at' => now()]);
        $waterPump = Image::factory()->create(['path' => 'images/waterpump.jpg']);

        $product = Product::factory()->create();

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
