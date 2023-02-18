<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Tests\TestCase;

class ReadPostsTest extends TestCase
{
    /** @test */
    public function guest_can_read_posts(): void
    {
        [$howTo, $aboutUs] = Post::factory()->count(2)->create();

        $this->get(route('posts.index'))
            ->assertSuccessful()
            ->assertViewIs('posts.index')
            ->assertViewHas('posts')
            ->assertSee($howTo->title)
            ->assertSee($aboutUs->title);
    }
}
