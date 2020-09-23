<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadPostTest extends TestCase
{
    use RefreshDatabase;

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
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.posts.show', $post))
            ->assertSuccessful()
            ->assertViewIs('admin.posts.show')
            ->assertViewHas('post')
            ->assertSee($post->title);
    }
}
