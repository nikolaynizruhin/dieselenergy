<?php

namespace Tests\Feature\Image;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateImageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_image_page()
    {
        $this->get(route('images.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_create_image_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('images.create'))
            ->assertViewIs('images.create');
    }

    /** @test */
    public function guest_cant_create_image()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $this->post(route('images.store'), [
            'images' => [$image],
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_image()
    {
        $this->withoutExceptionHandling();

        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('images.store'), [
                'images' => [$image],
            ])->assertRedirect(route('images.index'))
            ->assertSessionHas('status', 'Images was created successfully!');

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);
    }

    /** @test */
    public function user_cant_create_image_without_image()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('images.store'), [
                'images' => [null],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_create_image_with_integer_image()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('images.store'), [
                'images' => [1],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_create_image_with_pdf_file()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('products.store'), [
                'images' => [$pdf],
            ])->assertSessionHasErrors('images.*');
    }
}
