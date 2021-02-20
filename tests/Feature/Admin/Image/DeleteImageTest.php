<?php

namespace Tests\Feature\Admin\Image;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_image()
    {
        $image = Image::factory()->create();

        $this->delete(route('admin.images.destroy', $image))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_image()
    {
        $image = Image::factory()->create();

        $this->login()
            ->from(route('admin.images.index'))
            ->delete(route('admin.images.destroy', $image))
            ->assertRedirect(route('admin.images.index'))
            ->assertSessionHas('status', trans('image.deleted'));

        $this->assertDatabaseMissing('images', ['id' => $image->id]);
    }
}
