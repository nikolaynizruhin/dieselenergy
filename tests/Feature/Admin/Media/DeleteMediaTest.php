<?php

namespace Tests\Feature\Admin\Media;

use App\Media;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteMediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_media()
    {
        $media = factory(Media::class)->create();

        $this->delete(route('admin.medias.destroy', $media))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_media()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();

        $this->actingAs($user)
            ->from(route('admin.products.show', $media->product))
            ->delete(route('admin.medias.destroy', $media))
            ->assertRedirect(route('admin.products.show', $media->product))
            ->assertSessionHas('status', 'Image was detached successfully!');

        $this->assertDatabaseMissing('image_product', ['id' => $media->id]);
    }
}