<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortPostsTest extends TestCase
{


    /** @test */
    public function guest_cant_sort_posts()
    {
        $this->get(route('admin.posts.index', ['sort' => 'title']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_posts_by_title_ascending()
    {
        [$about, $history] = Post::factory()
            ->count(2)
            ->state(new Sequence(
                ['title' => 'About Us'],
                ['title' => 'History'],
            ))->create();

        $this->login()
            ->get(route('admin.posts.index', ['sort' => 'title']))
            ->assertSuccessful()
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts')
            ->assertSeeInOrder([$about->title, $history->title]);
    }

    /** @test */
    public function admin_can_sort_posts_by_title_descending()
    {
        [$about, $history] = Post::factory()
            ->count(2)
            ->state(new Sequence(
                ['title' => 'About Us'],
                ['title' => 'History'],
            ))->create();

        $this->login()
            ->get(route('admin.posts.index', ['sort' => '-title']))
            ->assertSuccessful()
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts')
            ->assertSeeInOrder([$history->title, $about->title]);
    }
}
