<?php

use App\Models\Post;

test('guest can read posts', function () {
    $post = Post::factory()->create();

    $this->get(route('posts.show', $post))
        ->assertSuccessful()
        ->assertViewIs('posts.show')
        ->assertViewHas('post')
        ->assertSee($post->title);
});
