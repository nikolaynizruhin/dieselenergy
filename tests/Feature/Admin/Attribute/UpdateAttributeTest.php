<?php

namespace Tests\Feature\Admin\Attribute;

use App\Attribute;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateAttributeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_attribute_page()
    {
        $attribute = factory(Attribute::class)->create();

        $this->get(route('admin.attributes.edit', $attribute))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_attribute_page()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->get(route('admin.attributes.edit', $attribute))
            ->assertViewIs('admin.attributes.edit')
            ->assertViewHas('attribute', $attribute);
    }

    /** @test */
    public function guest_cant_update_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $stub = factory(Attribute::class)->raw();

        $this->put(route('admin.attributes.update', $attribute), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_attribute()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();
        $stub = factory(Attribute::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.updated'));

        $this->assertDatabaseHas('attributes', $stub);
    }

    /** @test */
    public function user_cant_update_attribute_without_name()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();
        $stub = factory(Attribute::class)->raw(['name' => null]);

        $this->actingAs($user)
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_attribute_with_integer_name()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();
        $stub = factory(Attribute::class)->raw(['name' => 1]);

        $this->actingAs($user)
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_attribute_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();
        $stub = factory(Attribute::class)->raw(['name' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_attribute_with_existing_name()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();
        $existing = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->put(route('admin.attributes.update', $attribute), [
                'name' => $existing->name,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_attribute_with_integer_measure()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();
        $stub = factory(Attribute::class)->raw(['measure' => 1]);

        $this->actingAs($user)
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('measure');
    }

    /** @test */
    public function user_cant_update_attribute_with_measure_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();
        $stub = factory(Attribute::class)->raw(['measure' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('measure');
    }
}
