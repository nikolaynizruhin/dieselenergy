<?php

namespace Tests\Feature\Admin\Image;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadImagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_images()
    {
        $this->get(route('admin.images.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_images()
    {
        $user = User::factory()->create();

        $diesel = Image::factory()->create(['created_at' => now()->subDay()]);
        $patrol = Image::factory()->create(['created_at' => now()]);

        $this->actingAs($user)
            ->get(route('admin.images.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.images.index')
            ->assertViewHas('images')
            ->assertSeeInOrder([$patrol->path, $diesel->path]);
    }
}
