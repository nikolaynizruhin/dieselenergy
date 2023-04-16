<?php

use App\Models\Image;
use App\Models\Post;

it('has image', function () {
    $post = Post::factory()->create();

    $this->assertInstanceOf(Image::class, $post->image);
});
