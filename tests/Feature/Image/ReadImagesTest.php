<?php

namespace Tests\Feature\Image;

use App\Image;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadImagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_images()
    {
        $this->get(route('images.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_images()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        [$diesel, $patrol] = factory(Image::class, 2)->create();

        $this->actingAs($user)
            ->get(route('images.index'))
            ->assertSuccessful()
            ->assertViewIs('images.index')
            ->assertViewHas('images')
            ->assertSee($diesel->path)
            ->assertSee($patrol->path);
    }
}
