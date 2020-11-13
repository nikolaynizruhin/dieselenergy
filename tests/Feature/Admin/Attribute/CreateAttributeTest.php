<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateAttributeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_attribute_page()
    {
        $this->get(route('admin.attributes.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_attribute_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $attribute = Attribute::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.created'));

        $this->assertDatabaseHas('attributes', $attribute);
    }

    /** @test */
    public function user_cant_create_attribute_without_name()
    {
        $user = User::factory()->create();

        $attribute = Attribute::factory()->raw(['name' => null]);

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), $attribute)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_attribute_with_integer_name()
    {
        $user = User::factory()->create();

        $attribute = Attribute::factory()->raw(['name' => 1]);

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), $attribute)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_attribute_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();

        $attribute = Attribute::factory()->raw(['name' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $attribute)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_attribute_with_existing_name()
    {
        $user = User::factory()->create();
        $attribute = Attribute::factory()->create();
        $stub = Attribute::factory()->raw(['name' => $attribute->name]);

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_attribute_with_integer_measure()
    {
        $user = User::factory()->create();

        $attribute = Attribute::factory()->raw(['measure' => 1]);

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), $attribute)
            ->assertSessionHasErrors('measure');
    }

    /** @test */
    public function user_cant_create_attribute_with_measure_more_than_255_chars()
    {
        $user = User::factory()->create();

        $attribute = Attribute::factory()->raw(['measure' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), $attribute)
            ->assertSessionHasErrors('measure');
    }
}
