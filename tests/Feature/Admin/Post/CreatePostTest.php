<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use HasValidation;

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
     *
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
        return $this->provider();
    }
}
