<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchPostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_posts()
    {
        $post = Post::factory()->create();

        $this->get(route('admin.posts.index', ['search' => $post->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_posts()
    {
        [$aboutUs, $howTo, $comparison] = Post::factory()
            ->count(3)
            ->state(new Sequence(
                [
                    'title' => 'About Us Post',
                    'created_at' => now()->subHour(),
                ],
                [
                    'title' => 'How To Post',
                ],
                [
                    'title' => 'Comparison',
                ],
            ))->create();

        $this->login()
            ->get(route('admin.posts.index', ['search' => 'Post']))
            ->assertSeeInOrder([$howTo->title, $aboutUs->title])
            ->assertDontSee($comparison->title);
    }
}
