<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;
use App\Models\Product;
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
        $product = Product::factory()->create();

        $this->login()
            ->get(route('admin.medias.create', ['product_id' => $product->id]))
            ->assertViewIs('admin.medias.create');
    }

    /** @test */
    public function guest_cant_create_media()
    {
        $media = Media::factory()->raw();

        $this->post(route('admin.medias.store'), $media)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_media()
    {
        $media = Media::factory()->raw();

        $this->login()
            ->post(route('admin.medias.store'), $media)
            ->assertRedirect(route('admin.products.show', $media['product_id']))
            ->assertSessionHas('status', trans('media.created'));

        $this->assertDatabaseHas('image_product', $media);
    }

    /** @test */
    public function it_should_unmark_other_default_medias()
    {
        $media = Media::factory()->default()->create();
        $stub = Media::factory()->default()->raw([
            'product_id' => $media->product_id,
        ]);

        $this->login()
            ->post(route('admin.medias.store'), $stub)
            ->assertRedirect();

        $this->assertFalse($media->fresh()->is_default);
    }

    /** @test */
    public function user_cant_create_media_without_product()
    {
        $media = Media::factory()->raw(['product_id' => null]);

        $this->login()
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_media_with_string_product()
    {
        $media = Media::factory()->raw(['product_id' => 'string']);

        $this->login()
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_media_with_nonexistent_product()
    {
        $media = Media::factory()->raw(['product_id' => 10]);

        $this->login()
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_media_without_image()
    {
        $media = Media::factory()->raw(['image_id' => null]);

        $this->login()
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_create_media_with_string_image()
    {
        $media = Media::factory()->raw(['image_id' => 'string']);

        $this->login()
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_create_media_with_nonexistent_image()
    {
        $media = Media::factory()->raw(['image_id' => 10]);

        $this->login()
            ->post(route('admin.medias.store'), $media)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_create_existing_media()
    {
        $media = Media::factory()->create();

        $this->login()
            ->post(route('admin.medias.store'), $media->toArray())
            ->assertSessionHasErrors('product_id');
    }
}
