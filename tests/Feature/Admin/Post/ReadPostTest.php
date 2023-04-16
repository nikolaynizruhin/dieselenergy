<?php

use App\Models\Post;

test('guest cant read post', function () {
    $post = Post::factory()->create();

    $this->get(route('admin.posts.show', $post))
        ->assertRedirect(route('admin.login'));
});

test('user can read post', function () {
    $post = Post::factory()->create();

    $this->login()
        ->get(route('admin.posts.show', $post))
        ->assertSuccessful()
        ->assertViewIs('admin.posts.show')
        ->assertViewHas('post')
        ->assertSee($post->title);
});
