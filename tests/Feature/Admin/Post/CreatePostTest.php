<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_post_page()
    {
        $this->get(route('admin.posts.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_post_page()
    {
        $this->login()
            ->get(route('admin.posts.create'))
            ->assertViewIs('admin.posts.create');
    }

    /** @test */
    public function guest_cant_create_post()
    {
        $post = Post::factory()->raw();

        $this->post(route('admin.posts.store'), $post)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_post()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('post.jpg');

        $post = Post::factory()
            ->make()
            ->makeHidden('image_id')
            ->toArray();

        $this->login()
            ->post(route('admin.posts.store'), $post + [
                'image' => $image,
            ])->assertRedirect(route('admin.posts.index'))
            ->assertSessionHas('status', trans('post.created'));

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);
        $this->assertDatabaseHas('posts', $post + [
            'image_id' => Image::firstWhere('path', $path)->id,
        ]);
    }

    /** @test */
    public function user_cant_create_post_without_title()
    {
        $post = Post::factory()->raw(['title' => null]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_cant_create_post_with_integer_title()
    {
        $post = Post::factory()->raw(['title' => 1]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_cant_create_post_without_excerpt()
    {
        $post = Post::factory()->raw(['excerpt' => null]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('excerpt');
    }

    /** @test */
    public function user_cant_create_post_with_integer_excerpt()
    {
        $post = Post::factory()->raw(['excerpt' => 1]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('excerpt');
    }

    /** @test */
    public function user_cant_create_post_with_title_more_than_255_chars()
    {
        $post = Post::factory()->raw(['title' => str_repeat('a', 256)]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_cant_create_post_with_existing_title()
    {
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['title' => $post->title]);

        $this->login()
            ->post(route('admin.posts.store'), $stub)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_cant_create_post_without_slug()
    {
        $post = Post::factory()->raw(['slug' => null]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_post_with_integer_slug()
    {
        $post = Post::factory()->raw(['slug' => 1]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_post_with_slug_more_than_255_chars()
    {
        $post = Post::factory()->raw(['slug' => str_repeat('a', 256)]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_post_with_existing_slug()
    {
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['slug' => $post->slug]);

        $this->login()
            ->post(route('admin.posts.store'), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_post_without_body()
    {
        $post = Post::factory()->raw(['body' => null]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function user_cant_create_post_with_integer_body()
    {
        $post = Post::factory()->raw(['body' => 1]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function user_cant_create_post_without_image()
    {
        $post = Post::factory()->raw(['image' => null]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('image');
    }

    /** @test */
    public function user_cant_create_post_with_string_image()
    {
        $post = Post::factory()->raw(['image' => 'string']);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('image');
    }

    /** @test */
    public function user_cant_create_product_with_integer_image()
    {
        $post = Post::factory()->raw(['image' => 1]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('image');
    }

    /** @test */
    public function user_cant_create_post_with_pdf_file()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $post = Post::factory()->raw(['image' => $pdf]);

        $this->login()
            ->post(route('admin.posts.store'), $post)
            ->assertSessionHasErrors('image');
    }
}
