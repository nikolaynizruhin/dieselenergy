<?php

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('user can read medias', function () {
    [$diesel, $patrol] = Image::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()->subDay()],
            ['created_at' => now()],
        ))->create();

    $product = Product::factory()->create();

    $product->images()->attach([$diesel->id, $patrol->id]);

    $this->login()
        ->get(route('admin.products.show', $product))
        ->assertSuccessful()
        ->assertViewIs('admin.products.show')
        ->assertViewHas('images')
        ->assertSeeInOrder([$patrol->path, $diesel->path]);
});
