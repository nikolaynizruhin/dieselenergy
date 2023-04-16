<?php

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search images', function () {
    $image = Image::factory()->create();

    $this->get(route('admin.images.index', ['search' => $image->path]))
        ->assertRedirect(route('admin.login'));
});

test('user can search images', function () {
    [$diesel, $patrol, $waterPump] = Image::factory()
        ->count(3)
        ->state(new Sequence(
            ['path' => 'images/abcpath.jpg', 'created_at' => now()->subDay()],
            ['path' => 'images/bcapath.jpg'],
            ['path' => 'images/token.jpg'],
        ))->create();

    $this->login()
        ->get(route('admin.images.index', ['search' => 'path']))
        ->assertSeeInOrder([$patrol->name, $diesel->path])
        ->assertDontSee($waterPump->path);
});
