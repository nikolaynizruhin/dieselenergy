<?php

use App\Models\Attribute;
use App\Models\Specification;

it('has_attribute', function () {
    $specification = Specification::factory()
        ->forAttribute()
        ->create();

    $this->assertInstanceOf(Attribute::class, $specification->attribute);
});

it('can_toggle_feature', function () {
    $specification = Specification::factory()
        ->regular()
        ->forAttribute()
        ->create();

    $specification->toggle();

    $this->assertTrue($specification->is_featured);
});
