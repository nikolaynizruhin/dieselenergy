<?php

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search attributes', function () {
    $attribute = Attribute::factory()->create();

    $this->get(route('admin.attributes.index', ['search' => $attribute->name]))
        ->assertRedirect(route('admin.login'));
});

test('user can search attributes', function () {
    [$power, $width, $height] = Attribute::factory()
        ->count(3)
        ->state(new Sequence(
            ['name' => 'power'],
            ['name' => 'width attribute'],
            ['name' => 'height attribute'],
        ))->create();

    $this->login()
        ->get(route('admin.attributes.index', ['search' => 'attribute']))
        ->assertSeeInOrder([$height->name, $width->name])
        ->assertDontSee($power->name);
});
