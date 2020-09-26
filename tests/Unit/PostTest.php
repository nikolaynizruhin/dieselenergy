<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_image()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Image::class, $post->image);
    }
}
