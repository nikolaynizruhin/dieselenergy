<?php

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search posts', function () {
    $post = Post::factory()->create();

    $this->get(route('admin.posts.index', ['search' => $post->name]))
        ->assertRedirect(route('admin.login'));
});

test('user can search posts', function () {
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
});
