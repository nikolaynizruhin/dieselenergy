<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadMediasTest extends TestCase
{
    /** @test */
    public function user_can_read_medias()
    {
        [$diesel, $patrol] = Image::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()->subDay()],
                ['created_at' => now()],
            ))->create();

        $product = Product::factory()->create();

        $product->images()->attach([$diesel->id, $patrol->id]);

        $this->login()
            ->get(route('admin.products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('admin.products.show')
            ->assertViewHas('images')
            ->assertSeeInOrder([$patrol->path, $diesel->path]);
    }
}
