<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortPostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * About Us post.
     *
     * @var \App\Models\Post
     */
    private $about;

    /**
     * History post.
     *
     * @var \App\Models\Post
     */
    private $history;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->about, $this->history] = Post::factory()
            ->count(2)
            ->state(new Sequence(
                ['title' => 'About Us'],
                ['title' => 'History'],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_posts()
    {
        $this->get(route('admin.posts.index', ['sort' => 'title']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_posts_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.posts.index', ['sort' => 'title']))
            ->assertSuccessful()
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts')
            ->assertSeeInOrder([$this->about->title, $this->history->title]);
    }

    /** @test */
    public function admin_can_sort_posts_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.posts.index', ['sort' => '-title']))
            ->assertSuccessful()
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts')
            ->assertSeeInOrder([$this->history->title, $this->about->title]);
    }
}
