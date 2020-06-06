<?php

namespace Tests\Feature\Admin\Image;

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

        $this->get(route('admin.images.index', ['search' => $image->path]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_images()
    {
        $user = factory(User::class)->create();

        $diesel = factory(Image::class)->create(['path' => 'images/abcpath.jpg', 'created_at' => now()->subDay()]);
        $patrol = factory(Image::class)->create(['path' => 'images/bcapath.jpg', 'created_at' => now()]);
        $waterPump = factory(Image::class)->create(['path' => 'images/token.jpg']);

        $this->actingAs($user)
            ->get(route('admin.images.index', ['search' => 'path']))
            ->assertSeeInOrder([$patrol->name, $diesel->path])
            ->assertDontSee($waterPump->path);
    }
}
