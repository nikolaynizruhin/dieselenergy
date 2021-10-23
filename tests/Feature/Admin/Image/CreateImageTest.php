<?php

namespace Tests\Feature\Admin\Image;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateImageTest extends TestCase
{
    /** @test */
    public function guest_cant_visit_create_image_page()
    {
        $this->get(route('admin.images.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_image_page()
    {
        $this->login()
            ->get(route('admin.images.create'))
            ->assertViewIs('admin.images.create');
    }

    /** @test */
    public function guest_cant_create_image()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $this->post(route('admin.images.store'), [
            'images' => [$image],
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_image()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $this->login()
            ->post(route('admin.images.store'), [
                'images' => [$image],
            ])->assertRedirect(route('admin.images.index'))
            ->assertSessionHas('status', trans('image.created'));

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_image_with_invalid_data($data)
    {
        $this->login()
            ->from(route('admin.images.create'))
            ->post(route('admin.images.store'), ['images' => $data()])
            ->assertRedirect(route('admin.images.create'))
            ->assertSessionHasErrors('images.*');

        $this->assertDatabaseCount('images', 0);
    }

    public function validationProvider(): array
    {
        return [
            'Image is required' => [
                fn () => [null],
            ],
            'Image cant be an integer' => [
                fn () => [1],
            ],
            'Image cant be a pdf file' => [
                fn () => [UploadedFile::fake()->create('document.pdf', 1, 'application/pdf')],
            ],
        ];
    }
}
