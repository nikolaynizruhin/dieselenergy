<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    /**
     * Post.
     *
     * @var \App\Models\Post
     */
    private $post;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_post()
    {
        $this->delete(route('admin.posts.destroy', $this->post))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_post()
    {
        $this->login()
            ->from(route('admin.posts.index'))
            ->delete(route('admin.posts.destroy', $this->post))
            ->assertRedirect(route('admin.posts.index'))
            ->assertSessionHas('status', trans('post.deleted'));

        $this->assertModelMissing($this->post);
    }
}
