<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateAttributeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_attribute_page()
    {
        $attribute = Attribute::factory()->create();

        $this->get(route('admin.attributes.edit', $attribute))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_attribute_page()
    {
        $attribute = Attribute::factory()->create();

        $this->login()
            ->get(route('admin.attributes.edit', $attribute))
            ->assertViewIs('admin.attributes.edit')
            ->assertViewHas('attribute', $attribute);
    }

    /** @test */
    public function guest_cant_update_attribute()
    {
        $attribute = Attribute::factory()->create();

        $stub = Attribute::factory()->raw();

        $this->put(route('admin.attributes.update', $attribute), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_attribute()
    {
        $attribute = Attribute::factory()->create();
        $stub = Attribute::factory()->raw();

        $this->login()
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.updated'));

        $this->assertDatabaseHas('attributes', $stub);
    }

    /** @test */
    public function user_cant_update_attribute_without_name()
    {
        $attribute = Attribute::factory()->create();
        $stub = Attribute::factory()->raw(['name' => null]);

        $this->login()
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_attribute_with_integer_name()
    {
        $attribute = Attribute::factory()->create();
        $stub = Attribute::factory()->raw(['name' => 1]);

        $this->login()
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_attribute_with_name_more_than_255_chars()
    {
        $attribute = Attribute::factory()->create();
        $stub = Attribute::factory()->raw(['name' => str_repeat('a', 256)]);

        $this->login()
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_attribute_with_existing_name()
    {
        $attribute = Attribute::factory()->create();
        $existing = Attribute::factory()->create();

        $this->login()
            ->put(route('admin.attributes.update', $attribute), [
                'name' => $existing->name,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_attribute_with_integer_measure()
    {
        $attribute = Attribute::factory()->create();
        $stub = Attribute::factory()->raw(['measure' => 1]);

        $this->login()
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('measure');
    }

    /** @test */
    public function user_cant_update_attribute_with_measure_more_than_255_chars()
    {
        $attribute = Attribute::factory()->create();
        $stub = Attribute::factory()->raw(['measure' => str_repeat('a', 256)]);

        $this->login()
            ->put(route('admin.attributes.update', $attribute), $stub)
            ->assertSessionHasErrors('measure');
    }
}
