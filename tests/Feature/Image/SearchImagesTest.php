<?php

namespace Tests\Feature\Image;

use App\Image;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchImagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_images()
    {
        $image = factory(Image::class)->create();

        $this->get(route('images.index', ['search' => $image->path]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_search_images()
    {
        $user = factory(User::class)->create();

        $diesel = factory(Image::class)->create();
        $patrol = factory(Image::class)->create();

        $this->actingAs($user)
            ->get(route('images.index', ['search' => $diesel->path]))
            ->assertSee($diesel->path)
            ->assertDontSee($patrol->path);
    }
}
