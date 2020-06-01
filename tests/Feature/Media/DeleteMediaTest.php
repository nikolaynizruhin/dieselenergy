<?php

namespace Tests\Feature\Media;

use App\Image;
use App\Media;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteMediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_media()
    {
        $media = factory(Media::class)->create();

        $this->delete(route('medias.destroy', $media))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_media()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();

        $this->actingAs($user)
            ->from(route('products.show', $media->product))
            ->delete(route('medias.destroy', $media))
            ->assertRedirect(route('products.show', $media->product))
            ->assertSessionHas('status', 'Image was detached successfully!');

        $this->assertDatabaseMissing('image_product', ['id' => $media->id]);
    }
}
