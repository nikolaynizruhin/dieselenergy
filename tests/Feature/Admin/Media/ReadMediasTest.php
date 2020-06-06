<?php

namespace Tests\Feature\Admin\Media;

use App\Media;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadMediasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_medias()
    {
        $user = factory(User::class)->create();

        $media = factory(Media::class)->create();

        $this->actingAs($user)
            ->get(route('admin.products.show', $media->product))
            ->assertSuccessful()
            ->assertViewIs('admin.products.show')
            ->assertViewHas('images')
            ->assertSee($media->image->path);
    }
}
