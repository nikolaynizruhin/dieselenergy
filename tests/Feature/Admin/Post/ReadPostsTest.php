<?php

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read posts', function () {
    $this->get(route('admin.posts.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read posts', function () {
    [$aboutUs, $howTo] = Post::factory()
        ->count(2)
        ->state(new Sequence(
            [
                'title' => 'About Us',
                'created_at' => now()->subHour(),
            ],
            [
                'title' => 'How To',
            ],
        ))->create();

    $this->login()
        ->get(route('admin.posts.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.posts.index')
        ->assertViewHas('posts')
        ->assertSeeInOrder([$howTo->title, $aboutUs->title]);
});
