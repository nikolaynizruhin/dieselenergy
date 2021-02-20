<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchMediasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_media()
    {


        [$diesel, $patrol, $waterPump] = Image::factory()
            ->count(3)
            ->state(new Sequence(
                ['path' => 'images/dieselpath.jpg', 'created_at' => now()->subDay()],
                ['path' => 'images/patrolpath.jpg'],
                ['path' => 'images/waterpump.jpg'],
            ))->create();

        $product = Product::factory()->create();

        $product->images()->attach([$diesel->id, $patrol->id]);

        $this->login()
            ->get(route('admin.products.show', [
                'product' => $product,
                'search' => 'path',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$patrol->path, $diesel->path])
            ->assertDontSee($waterPump->path);
    }
}
