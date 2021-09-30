<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
    /** @test */
    public function it_has_image()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Image::class, $post->image);
    }
}
