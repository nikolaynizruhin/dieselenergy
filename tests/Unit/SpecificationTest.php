<?php

use App\Models\Attribute;
use App\Models\Specification;

it('has_attribute', function () {
    $specification = Specification::factory()
        ->forAttribute()
        ->create();

    expect($specification->attribute)->toBeInstanceOf(Attribute::class);
});

it('can_toggle_feature', function () {
    $specification = Specification::factory()
        ->regular()
        ->forAttribute()
        ->create();

    $specification->toggle();

    expect($specification->is_featured)->toBeTrue();
});
