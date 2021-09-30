<?php

namespace Tests\Feature\Admin\Image;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadImagesTest extends TestCase
{
    /** @test */
    public function guest_cant_read_images()
    {
        $this->get(route('admin.images.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_images()
    {
        [$diesel, $patrol] = Image::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()->subDay()],
                ['created_at' => now()],
            ))->create();

        $this->login()
            ->get(route('admin.images.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.images.index')
            ->assertViewHas('images')
            ->assertSeeInOrder([$patrol->path, $diesel->path]);
    }
}
