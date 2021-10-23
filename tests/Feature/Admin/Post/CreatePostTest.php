<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
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
        $this->post(route('admin.posts.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_post()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('post.jpg');

        $post = $this->validFields();

        unset($post['image_id']);

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

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_post_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.posts.create'))
            ->post(route('admin.posts.store'), $data())
            ->assertRedirect(route('admin.posts.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('posts', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Title is required' => [
                'title', fn () => $this->validFields(['title' => null]),
            ],
            'Title cant be an integer' => [
                'title', fn () => $this->validFields(['title' => 1]),
            ],
            'Title cant be more than 255 chars' => [
                'title', fn () => $this->validFields(['title' => Str::random(256)]),
            ],
            'Title must be unique' => [
                'title', fn () => $this->validFields(['title' => Post::factory()->create()->title]), 1,
            ],
            'Excerpt is required' => [
                'excerpt', fn () => $this->validFields(['excerpt' => null]),
            ],
            'Excerpt cant be an integer' => [
                'excerpt', fn () => $this->validFields(['excerpt' => 1]),
            ],
            'Slug must be unique' => [
                'slug', fn () => $this->validFields(['slug' => Post::factory()->create()->slug]), 1,
            ],
            'Slug is required' => [
                'slug', fn () => $this->validFields(['slug' => null]),
            ],
            'Slug cant be an integer' => [
                'slug', fn () => $this->validFields(['slug' => 1]),
            ],
            'Slug cant be more than 255 chars' => [
                'slug', fn () => $this->validFields(['slug' => Str::random(256)]),
            ],
            'Body is required' => [
                'body', fn () => $this->validFields(['body' => null]),
            ],
            'Body cant be an integer' => [
                'body', fn () => $this->validFields(['body' => 1]),
            ],
            'Image is required' => [
               'image', fn () => $this->validFields(['image' => null]),
            ],
            'Image cant be an integer' => [
                'image', fn () => $this->validFields(['image' => 1]),
            ],
            'Image cant be a string' => [
                'image', fn () => $this->validFields(['image' => 'string']),
            ],
            'Image cant be a pdf file' => [
                'image', fn () => $this->validFields(['image' => UploadedFile::fake()->create('document.pdf', 1, 'application/pdf')]),
            ],
        ];
    }

    /**
     * Get valid contact fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Post::factory()->raw($overrides);
    }
}
