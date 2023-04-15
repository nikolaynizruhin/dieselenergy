<?php

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('user can search media', function () {
    [$diesel, $patrol, $waterPump] = Image::factory()
        ->count(3)
        ->state(new Sequence(
            ['path' => 'images/dieselpath.jpg', 'created_at' => now()->subDay()],
            ['path' => 'images/patrolpath.jpg'],
            ['path' => 'images/waterpump.jpg'],
        ))->create();

    $product = Product::factory()->create();

    $product->images()->attach([$diesel->id, $patrol->id]);

    $this->login()
        ->get(route('admin.products.show', [
            'product' => $product,
            'search' => 'path',
        ]))->assertSuccessful()
        ->assertSeeInOrder([$patrol->path, $diesel->path])
        ->assertDontSee($waterPump->path);
});
