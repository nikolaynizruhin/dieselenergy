<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateMediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_update_media_page()
    {
        $media = Media::factory()->create();

        $this->get(route('admin.medias.edit', $media))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_media_page()
    {
        $user = User::factory()->create();
        $media = Media::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.medias.edit', $media))
            ->assertViewIs('admin.medias.edit');
    }

    /** @test */
    public function guest_cant_update_media()
    {
        $media = Media::factory()->create();
        $stub = Media::factory()->raw();

        $this->put(route('admin.medias.update', $media), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_media()
    {
        $user = User::factory()->create();
        $media = Media::factory()->create();
        $stub = Media::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertRedirect(route('admin.products.show', $stub['product_id']))
            ->assertSessionHas('status', trans('media.updated'));

        $this->assertDatabaseHas('image_product', $stub);
    }

    /** @test */
    public function it_should_unmark_other_default_medias()
    {
        $user = User::factory()->create();

        $defaultMedia = Media::factory()
            ->default()
            ->create();

        $media = Media::factory()->create([
            'is_default' => 0,
            'product_id' => $defaultMedia->product_id,
        ]);

        $stub = Media::factory()
            ->default()
            ->raw(['product_id' => $defaultMedia->product_id]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertRedirect();

        $this->assertFalse($defaultMedia->fresh()->is_default);
    }

    /** @test */
    public function user_cant_update_media_without_product()
    {
        $user = User::factory()->create();
        $media = Media::factory()->create();
        $stub = Media::factory()->raw(['product_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_media_with_string_product()
    {
        $user = User::factory()->create();
        $media = Media::factory()->create();
        $stub = Media::factory()->raw(['product_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_media_with_nonexistent_product()
    {
        $user = User::factory()->create();
        $media = Media::factory()->create();
        $stub = Media::factory()->raw(['product_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_media_without_image()
    {
        $user = User::factory()->create();
        $media = Media::factory()->create();
        $stub = Media::factory()->raw(['image_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_update_media_with_string_image()
    {
        $user = User::factory()->create();
        $media = Media::factory()->create();
        $stub = Media::factory()->raw(['image_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('image_id');
    }

    /** @test */
    public function user_cant_update_media_with_nonexistent_image()
    {
        $user = User::factory()->create();
        $media = Media::factory()->create();
        $stub = Media::factory()->raw(['image_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.medias.update', $media), $stub)
            ->assertSessionHasErrors('image_id');
    }
}
