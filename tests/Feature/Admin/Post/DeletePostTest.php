<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePostTest extends TestCase
{


    /** @test */
    public function guest_cant_delete_post()
    {
        $post = Post::factory()->create();

        $this->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_post()
    {
        $post = Post::factory()->create();

        $this->login()
            ->from(route('admin.posts.index'))
            ->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.posts.index'))
            ->assertSessionHas('status', trans('post.deleted'));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
