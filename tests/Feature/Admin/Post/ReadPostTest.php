<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use Tests\TestCase;

class ReadPostTest extends TestCase
{
    /** @test */
    public function guest_cant_read_post()
    {
        $post = Post::factory()->create();

        $this->get(route('admin.posts.show', $post))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_post()
    {
        $post = Post::factory()->create();

        $this->login()
            ->get(route('admin.posts.show', $post))
            ->assertSuccessful()
            ->assertViewIs('admin.posts.show')
            ->assertViewHas('post')
            ->assertSee($post->title);
    }
}
