<?php

namespace Tests\Feature\Admin\Image;

use App\Image;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_image()
    {
        $image = factory(Image::class)->create();

        $this->delete(route('admin.images.destroy', $image))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_image()
    {
        $user = factory(User::class)->create();
        $image = factory(Image::class)->create();

        $this->actingAs($user)
            ->from(route('admin.images.index'))
            ->delete(route('admin.images.destroy', $image))
            ->assertRedirect(route('admin.images.index'))
            ->assertSessionHas('status', 'Image was deleted successfully!');

        $this->assertDatabaseMissing('images', ['id' => $image->id]);
    }
}