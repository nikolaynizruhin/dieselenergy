<?php

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search cart', function () {
    $attribute = Attribute::factory()->create(['name' => 'width attribute']);

    $category = Category::factory()->create();

    $category->attributes()->attach([$attribute->id]);

    $this->get(route('admin.categories.show', [
        'category' => $category,
        'search' => 'width',
    ]))->assertRedirect(route('admin.login'));
});

test('user can search specifications', function () {
    [$width, $height, $weight] = Attribute::factory()
        ->count(3)
        ->state(new Sequence(
            ['name' => 'width attribute'],
            ['name' => 'height attribute'],
            ['name' => 'weight property'],
        ))->create();

    $category = Category::factory()->create();

    $category->attributes()->attach([$width->id, $height->id, $weight->id]);

    $this->login()
        ->get(route('admin.categories.show', [
            'category' => $category,
            'search' => 'attribute',
        ]))->assertSuccessful()
        ->assertSeeInOrder([$height->name, $width->name])
        ->assertDontSee($weight->name);
});
