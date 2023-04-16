<?php

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read images', function () {
    $this->get(route('admin.images.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read images', function () {
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
});
