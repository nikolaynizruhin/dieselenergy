<?php

namespace Tests\Feature\Admin\Media;

use App\Media;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateMediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_update_media_page()
    {
        $media = factory(Media::class)->create();

        $this->get(route('admin.medias.edit', $media))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_media_page()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();

        $this->actingAs($user)
            ->get(route('admin.medias.edit', $media))
            ->assertViewIs('admin.medias.edit');
    }

    /** @test */
    public function guest_cant_update_media()
    {
        $media = factory(Media::class)->create();
        $stub = factory(Media::class)->raw();

        $this->put(route('admin.medias.update', $media), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_media()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();
        $stub = factory(Media::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertRedirect(route('admin.products.show', $stub['product_id']))
            ->assertSessionHas('status', trans('media.updated'));

        $this->assertDatabaseHas('image_product', $stub);
    }

    /** @test */
    public function user_cant_update_media_without_product()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();
        $stub = factory(Media::class)->raw(['product_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_media_with_string_product()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();
        $stub = factory(Media::class)->raw(['product_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_media_with_nonexistent_product()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();
        $stub = factory(Media::class)->raw(['product_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_media_without_image()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();
        $stub = factory(Media::class)->raw(['image_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_update_media_with_string_image()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();
        $stub = factory(Media::class)->raw(['image_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_update_media_with_nonexistent_image()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();
        $stub = factory(Media::class)->raw(['image_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('image_id');
    }
}
