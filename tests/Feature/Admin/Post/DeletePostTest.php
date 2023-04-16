<?php

use App\Models\Post;

beforeEach(function () {
    $this->post = Post::factory()->create();
});

test('guest cant delete post', function () {
    $this->delete(route('admin.posts.destroy', $this->post))
        ->assertRedirect(route('admin.login'));
});

test('user can delete post', function () {
    $this->login()
        ->from(route('admin.posts.index'))
        ->delete(route('admin.posts.destroy', $this->post))
        ->assertRedirect(route('admin.posts.index'))
        ->assertSessionHas('status', trans('post.deleted'));

    $this->assertModelMissing($this->post);
});
