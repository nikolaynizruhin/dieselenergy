<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteMediaTest extends TestCase
{


    /** @test */
    public function guest_cant_delete_media()
    {
        $media = Media::factory()->create();

        $this->delete(route('admin.medias.destroy', $media))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_media()
    {
        $media = Media::factory()->create();

        $this->login()
            ->from(route('admin.products.show', $media->product))
            ->delete(route('admin.medias.destroy', $media))
            ->assertRedirect(route('admin.products.show', $media->product))
            ->assertSessionHas('status', trans('media.deleted'));

        $this->assertDatabaseMissing('image_product', ['id' => $media->id]);
    }
}
