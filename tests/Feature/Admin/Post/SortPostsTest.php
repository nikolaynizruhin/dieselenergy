<?php

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort posts', function () {
    $this->get(route('admin.posts.index', ['sort' => 'title']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort posts by title ascending', function () {
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
});

test('admin can sort posts by title descending', function () {
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
});
