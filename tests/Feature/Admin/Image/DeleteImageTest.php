<?php

namespace Tests\Feature\Admin\Image;

use App\Models\Image;
use Tests\TestCase;

class DeleteImageTest extends TestCase
{
    /**
     * Image.
     *
     * @var \App\Models\Image
     */
    private $image;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->image = Image::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_image()
    {
        $this->delete(route('admin.images.destroy', $this->image))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_image()
    {
        $this->login()
            ->from(route('admin.images.index'))
            ->delete(route('admin.images.destroy', $this->image))
            ->assertRedirect(route('admin.images.index'))
            ->assertSessionHas('status', trans('image.deleted'));

        $this->assertDeleted($this->image);
    }
}
