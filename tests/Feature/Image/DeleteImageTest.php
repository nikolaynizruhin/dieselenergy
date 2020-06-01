<?php

namespace Tests\Feature\Image;

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

        $this->delete(route('images.destroy', $image))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_image()
    {
        $user = factory(User::class)->create();
        $image = factory(Image::class)->create();

        $this->actingAs($user)
            ->from(route('images.index'))
            ->delete(route('images.destroy', $image))
            ->assertRedirect(route('images.index'))
            ->assertSessionHas('status', 'Image was deleted successfully!');

        $this->assertDatabaseMissing('images', ['id' => $image->id]);
    }
}
