<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use HasValidation;

    /**
     * Post.
     */
    private Post $post;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_post_page(): void
    {
        $this->get(route('admin.posts.edit', $this->post))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_post_page(): void
    {
        $this->login()
            ->get(route('admin.posts.edit', $this->post))
            ->assertViewIs('admin.posts.edit')
            ->assertViewHas('post', $this->post);
    }

    /** @test */
    public function guest_cant_update_post(): void
    {
        $this->put(route('admin.posts.update', $this->post), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_post(): void
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('post.jpg');

        $stub = self::validFields();

        unset($stub['image_id']);

        $this->login()
            ->put(route('admin.posts.update', $this->post), $stub + [
                'image' => $image,
            ])->assertRedirect(route('admin.posts.index'))
            ->assertSessionHas('status', trans('post.updated'));

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);
        $this->assertDatabaseHas('posts', $stub + [
            'image_id' => Image::firstWhere('path', $path)->id,
        ]);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_update_post_with_invalid_data(string $field, callable $data, int $count = 1): void
    {
        $this->login()
            ->from(route('admin.posts.edit', $this->post))
            ->put(route('admin.posts.update', $this->post), $data())
            ->assertRedirect(route('admin.posts.edit', $this->post))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('posts', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider(2);
    }
}
