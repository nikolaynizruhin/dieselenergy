<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;
use Tests\TestCase;

class UpdateMediaTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\Media
     */
    private $media;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->media = Media::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_media_page()
    {
        $this->get(route('admin.medias.edit', $this->media))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_media_page()
    {
        $this->login()
            ->get(route('admin.medias.edit', $this->media))
            ->assertViewIs('admin.medias.edit');
    }

    /** @test */
    public function guest_cant_update_media()
    {
        $this->put(route('admin.medias.update', $this->media), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_media()
    {
        $this->login()
            ->put(route('admin.medias.update', $this->media), $fields = $this->validFields())
            ->assertRedirect(route('admin.products.show', $fields['product_id']))
            ->assertSessionHas('status', trans('media.updated'));

        $this->assertDatabaseHas('image_product', $fields);
    }

    /** @test */
    public function it_should_unmark_other_default_medias()
    {
        $defaultMedia = Media::factory()
            ->default()
            ->create();

        $media = Media::factory()
            ->nonDefault()
            ->create(['product_id' => $defaultMedia->product_id]);

        $this->login()
            ->put(route('admin.medias.update', $media), $this->validFields([
                'product_id' => $defaultMedia->product_id,
                'is_default' => 1,
            ]))->assertRedirect();

        $this->assertFalse($defaultMedia->fresh()->is_default);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_media_with_invalid_data($field, $data)
    {
        $this->login()
            ->put(route('admin.medias.update', $this->media), $data())
            ->assertRedirect()
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('image_product', 1);
    }

    public function validationProvider(): array
    {
        return [
            'Product is required' => [
                'product_id', fn () => $this->validFields(['product_id' => null]),
            ],
            'Product cant be string' => [
                'product_id', fn () => $this->validFields(['product_id' => 'string']),
            ],
            'Product must exists' => [
                'product_id', fn () => $this->validFields(['product_id' => 10]),
            ],
            'Image is required' => [
                'image_id', fn () => $this->validFields(['image_id' => null]),
            ],
            'Image cant be string' => [
                'image_id', fn () => $this->validFields(['image_id' => 'string']),
            ],
            'Image must exists' => [
                'image_id', fn () => $this->validFields(['image_id' => 10]),
            ],
        ];
    }

    /**
     * Get valid media fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Media::factory()->raw($overrides);
    }
}
