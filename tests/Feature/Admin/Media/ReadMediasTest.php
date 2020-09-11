<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadMediasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_medias()
    {
        $user = User::factory()->create();

        $diesel = Image::factory()->create(['created_at' => now()->subDay()]);
        $patrol = Image::factory()->create(['created_at' => now()]);

        $product = Product::factory()->create();

        $product->images()->attach([$diesel->id, $patrol->id]);

        $this->actingAs($user)
            ->get(route('admin.products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('admin.products.show')
            ->assertViewHas('images')
            ->assertSeeInOrder([$patrol->path, $diesel->path]);
    }
}
