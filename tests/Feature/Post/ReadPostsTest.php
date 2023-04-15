<?php

use App\Models\Post;

test('guest can read posts', function () {
    [$howTo, $aboutUs] = Post::factory()->count(2)->create();

    $this->get(route('posts.index'))
        ->assertSuccessful()
        ->assertViewIs('posts.index')
        ->assertViewHas('posts')
        ->assertSee($howTo->title)
        ->assertSee($aboutUs->title);
});
