<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateAttributeTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function guest_cant_visit_create_attribute_page()
    {
        $this->get(route('admin.attributes.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_attribute_page()
    {
        $this->login()
            ->get(route('admin.attributes.create'))
            ->assertViewIs('admin.attributes.create');
    }

    /** @test */
    public function guest_cant_create_attribute()
    {
        $attribute = Attribute::factory()->raw();

        $this->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_attribute()
    {
        $attribute = Attribute::factory()->raw();

        $this->login()
            ->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.created'));

        $this->assertDatabaseHas('attributes', $attribute);
    }

    /** @test */
    public function user_cant_create_attribute_without_name()
    {
        $attribute = Attribute::factory()->raw(['name' => null]);

        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('attributes', 0);
    }

    /** @test */
    public function user_cant_create_attribute_with_integer_name()
    {
        $attribute = Attribute::factory()->raw(['name' => 1]);

        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('attributes', 0);
    }

    /** @test */
    public function user_cant_create_attribute_with_name_more_than_255_chars()
    {
        $attribute = Attribute::factory()->raw(['name' => str_repeat('a', 256)]);

        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('attributes', 0);
    }

    /** @test */
    public function user_cant_create_attribute_with_existing_name()
    {
        $attribute = Attribute::factory()->create();
        $stub = Attribute::factory()->raw(['name' => $attribute->name]);

        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $stub)
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('attributes', 1);
    }

    /** @test */
    public function user_cant_create_attribute_with_integer_measure()
    {
        $attribute = Attribute::factory()->raw(['measure' => 1]);

        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors('measure');

        $this->assertDatabaseCount('attributes', 0);
    }

    /** @test */
    public function user_cant_create_attribute_with_measure_more_than_255_chars()
    {
        $attribute = Attribute::factory()->raw(['measure' => str_repeat('a', 256)]);

        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors('measure');

        $this->assertDatabaseCount('attributes', 0);
    }
}
