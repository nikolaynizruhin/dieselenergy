<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadPostsTest extends TestCase
{
    /** @test */
    public function guest_cant_read_posts(): void
    {
        $this->get(route('admin.posts.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_posts(): void
    {
        [$aboutUs, $howTo] = Post::factory()
            ->count(2)
            ->state(new Sequence(
                [
                    'title' => 'About Us',
                    'created_at' => now()->subHour(),
                ],
                [
                    'title' => 'How To',
                ],
            ))->create();

        $this->login()
            ->get(route('admin.posts.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts')
            ->assertSeeInOrder([$howTo->title, $aboutUs->title]);
    }
}
