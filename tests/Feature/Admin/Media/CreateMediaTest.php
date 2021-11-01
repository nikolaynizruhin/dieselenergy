<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;
use App\Models\Product;
use Tests\TestCase;

class CreateMediaTest extends TestCase
{
    use HasValidation;

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
        $this->post(route('admin.medias.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_media()
    {
        $this->login()
            ->post(route('admin.medias.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.products.show', $fields['product_id']))
            ->assertSessionHas('status', trans('media.created'));

        $this->assertDatabaseHas('image_product', $fields);
    }

    /** @test */
    public function it_should_unmark_other_default_medias()
    {
        $media = Media::factory()->default()->create();
        $stub = Media::factory()->default()->raw([
            'product_id' => $media->product_id,
        ]);

        $this->login()
            ->from(route('admin.medias.create'))
            ->post(route('admin.medias.store'), $stub)
            ->assertRedirect(route('admin.products.show', $media->product));

        $this->assertFalse($media->fresh()->is_default);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_media_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->post(route('admin.medias.store'), $data())
            ->assertRedirect()
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('image_product', $count);
    }

    public function validationProvider(): array
    {
        return $this->provider() + [
            'Media must be unique' => [
                'product_id', fn () => Media::factory()->create()->toArray(), 1,
            ],
        ];
    }
}
