<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_read_posts()
    {
        $post = Post::factory()->create();

        $this->get(route('posts.show', $post))
            ->assertSuccessful()
            ->assertViewIs('posts.show')
            ->assertViewHas('post')
            ->assertSee($post->title);
    }
}
