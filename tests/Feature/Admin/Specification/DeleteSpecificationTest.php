<?php

use App\Models\Specification;

beforeEach(function () {
    $this->specification = Specification::factory()->create();
});

test('guest cant delete specification', function () {
    $this->delete(route('admin.specifications.destroy', $this->specification))
        ->assertRedirect(route('admin.login'));
});

test('user can delete specification', function () {
    $this->login()
        ->fromRoute('admin.categories.show', $this->specification->category_id)
        ->delete(route('admin.specifications.destroy', $this->specification))
        ->assertRedirect(route('admin.categories.show', $this->specification->category_id))
        ->assertSessionHas('status', trans('specification.deleted'));

    $this->assertModelMissing($this->specification);
});
