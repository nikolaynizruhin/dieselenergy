<?php

namespace Tests\Feature\Admin\Image;

use App\Models\User;
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
        $this->get(route('admin.images.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_image_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
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

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.images.store'), [
                'images' => [$image],
            ])->assertRedirect(route('admin.images.index'))
            ->assertSessionHas('status', trans('image.created'));

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);
    }

    /** @test */
    public function user_cant_create_image_without_image()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.images.store'), [
                'images' => [null],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_create_image_with_integer_image()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.images.store'), [
                'images' => [1],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_create_image_with_pdf_file()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'images' => [$pdf],
            ])->assertSessionHasErrors('images.*');
    }
}
