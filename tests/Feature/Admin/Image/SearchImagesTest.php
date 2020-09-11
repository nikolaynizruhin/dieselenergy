<?php

namespace Tests\Feature\Admin\Image;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchImagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_images()
    {
        $image = Image::factory()->create();

        $this->get(route('admin.images.index', ['search' => $image->path]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_images()
    {
        $user = User::factory()->create();

        $diesel = Image::factory()->create(['path' => 'images/abcpath.jpg', 'created_at' => now()->subDay()]);
        $patrol = Image::factory()->create(['path' => 'images/bcapath.jpg', 'created_at' => now()]);
        $waterPump = Image::factory()->create(['path' => 'images/token.jpg']);

        $this->actingAs($user)
            ->get(route('admin.images.index', ['search' => 'path']))
            ->assertSeeInOrder([$patrol->name, $diesel->path])
            ->assertDontSee($waterPump->path);
    }
}
