<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;
use Tests\TestCase;

class DeleteMediaTest extends TestCase
{
    /**
     * Media.
     *
     * @var \App\Models\Media
     */
    private $media;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->media = Media::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_media()
    {
        $this->delete(route('admin.medias.destroy', $this->media))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_media()
    {
        $this->login()
            ->from(route('admin.products.show', $this->media->product))
            ->delete(route('admin.medias.destroy', $this->media))
            ->assertRedirect(route('admin.products.show', $this->media->product))
            ->assertSessionHas('status', trans('media.deleted'));

        $this->assertDeleted($this->media);
    }
}
