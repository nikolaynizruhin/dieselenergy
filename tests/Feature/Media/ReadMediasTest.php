<?php

namespace Tests\Feature\Media;

use App\Image;
use App\Media;
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
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $media = factory(Media::class)->create();

        $this->actingAs($user)
            ->get(route('products.show', $media->product))
            ->assertSuccessful()
            ->assertViewIs('products.show')
            ->assertViewHas('images')
            ->assertSee($media->image->path);
    }
}
