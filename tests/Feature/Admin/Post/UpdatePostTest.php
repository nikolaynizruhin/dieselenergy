<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_update_post_page()
    {
        $post = Post::factory()->create();

        $this->get(route('admin.posts.edit', $post))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_post_page()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.posts.edit', $post))
            ->assertViewIs('admin.posts.edit')
            ->assertViewHas('post', $post);
    }

    /** @test */
    public function guest_cant_update_post()
    {
        $post = Post::factory()->create();
        $stub = Post::factory()->raw();

        $this->put(route('admin.posts.update', $post), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_post()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('post.jpg');

        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()
            ->make()
            ->makeHidden('image_id')
            ->toArray();

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub + [
                'image' => $image,
            ])->assertRedirect(route('admin.posts.index'))
            ->assertSessionHas('status', trans('post.updated'));

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);
        $this->assertDatabaseHas('posts', $stub + [
            'image_id' => Image::firstWhere('path', $path)->id,
        ]);
    }

    /** @test */
    public function user_cant_update_post_without_title()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['title' => null]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_cant_update_post_with_integer_title()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['title' => 1]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_cant_update_post_without_excerpt()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['excerpt' => null]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('excerpt');
    }

    /** @test */
    public function user_cant_update_post_with_integer_excerpt()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['excerpt' => 1]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('excerpt');
    }

    /** @test */
    public function user_cant_update_post_with_title_more_than_255_chars()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['title' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_cant_update_post_with_existing_title()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $existing = Post::factory()->create();
        $stub = Post::factory()->raw(['title' => $existing->title]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_cant_update_post_without_slug()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['slug' => null]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_update_post_with_integer_slug()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['slug' => 1]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_update_post_with_slug_more_than_255_chars()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['slug' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_update_post_with_existing_slug()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $existing = Post::factory()->create();
        $stub = Post::factory()->raw(['slug' => $existing->slug]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_update_post_without_body()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['body' => null]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function user_cant_update_post_with_integer_body()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['body' => 1]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function user_cant_update_post_without_image()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['image' => null]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('image');
    }

    /** @test */
    public function user_cant_update_post_with_string_image()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['image' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('image');
    }

    /** @test */
    public function user_cant_update_product_with_integer_image()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['image' => 1]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('image');
    }

    /** @test */
    public function user_cant_update_post_with_pdf_file()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $user = User::factory()->create();
        $post = Post::factory()->create();
        $stub = Post::factory()->raw(['image' => $pdf]);

        $this->actingAs($user)
            ->put(route('admin.posts.update', $post), $stub)
            ->assertSessionHasErrors('image');
    }
}
