<?php

namespace Tests\Feature\Admin\Image;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        [$diesel, $patrol, $waterPump] = Image::factory()
            ->count(3)
            ->state(new Sequence(
                ['path' => 'images/abcpath.jpg', 'created_at' => now()->subDay()],
                ['path' => 'images/bcapath.jpg'],
                ['path' => 'images/token.jpg'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.images.index', ['search' => 'path']))
            ->assertSeeInOrder([$patrol->name, $diesel->path])
            ->assertDontSee($waterPump->path);
    }
}
