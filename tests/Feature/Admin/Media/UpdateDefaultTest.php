<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;
use Tests\TestCase;

class UpdateDefaultTest extends TestCase
{
    /**
     * Product.
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

        $this->media = Media::factory()->regular()->create();
    }

    /** @test */
    public function guest_cant_update_default_media()
    {
        $this->put(route('admin.medias.default.update', $this->media))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_default_media()
    {
        $this->login()
            ->put(route('admin.medias.default.update', $this->media))
            ->assertRedirect(route('admin.products.show', $this->media->product_id))
            ->assertSessionHas('status', trans('media.updated'));

        $this->assertTrue($this->media->fresh()->is_default);
    }

    /** @test */
    public function it_should_unmark_other_default_medias()
    {
        $defaultMedia = Media::factory()
            ->default()
            ->create(['product_id' => $this->media->product_id]);

        $this->login()
            ->put(route('admin.medias.default.update', $this->media))
            ->assertRedirect();

        $this->assertFalse($defaultMedia->fresh()->is_default);
        $this->assertTrue($this->media->fresh()->is_default);
    }
}
