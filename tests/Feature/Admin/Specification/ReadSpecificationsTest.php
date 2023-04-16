<?php

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('user can read specifications', function () {
    [$width, $height] = Attribute::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'width attribute'],
            ['name' => 'height attribute'],
        ))->create();

    $category = Category::factory()->create();

    $category->attributes()->attach([$width->id, $height->id]);

    $this->login()
        ->get(route('admin.categories.show', $category))
        ->assertSuccessful()
        ->assertViewIs('admin.categories.show')
        ->assertViewHas('attributes')
        ->assertSeeInOrder([$height->name, $width->name]);
});
