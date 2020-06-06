<?php

namespace Tests\Feature\Admin\Media;

use App\Media;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateMediaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_media_page()
    {
        $this->get(route('admin.medias.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_media_page()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->get(route('admin.medias.create', ['product_id' => $product->id]))
            ->assertViewIs('admin.medias.create');
    }

    /** @test */
    public function guest_cant_create_media()
    {
        $media = factory(Media::class)->raw();

        $this->post(route('admin.medias.store'), $media)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_media()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->raw();

        $this->actingAs($user)
            ->post(route('admin.medias.store'), $media)
            ->assertRedirect(route('admin.products.show', $media['product_id']))
            ->assertSessionHas('status', 'Image was attached successfully!');

        $this->assertDatabaseHas('image_product', $media);
    }

    /** @test */
    public function user_cant_create_media_without_product()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->raw(['product_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_media_with_string_product()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->raw(['product_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_media_with_nonexistent_product()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->raw(['product_id' => 10]);

        $this->actingAs($user)
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_media_without_image()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->raw(['image_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_create_media_with_string_image()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->raw(['image_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_create_media_with_nonexistent_image()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->raw(['image_id' => 10]);

        $this->actingAs($user)
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_create_existing_media()
    {
        $user = factory(User::class)->create();
        $media = factory(Media::class)->create();

        $this->actingAs($user)
            ->post(route('admin.medias.store'), $media->toArray())
            ->assertSessionHasErrors('product_id');
    }
}
