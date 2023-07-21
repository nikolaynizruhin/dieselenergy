<?php

use App\Models\Image;
use App\Models\Post;

it('has image', function () {
    $post = Post::factory()->create();

    expect($post->image)->toBeInstanceOf(Image::class);
});
