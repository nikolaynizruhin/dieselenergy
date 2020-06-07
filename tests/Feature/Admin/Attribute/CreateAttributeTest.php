<?php

namespace Tests\Feature\Admin\Attribute;

use App\Attribute;
use App\User;
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
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.attributes.create'))
            ->assertViewIs('admin.attributes.create');
    }

    /** @test */
    public function guest_cant_create_attribute()
    {
        $attribute = factory(Attribute::class)->raw();

        $this->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_attribute()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->raw();

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), $attribute)
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.created'));

        $this->assertDatabaseHas('attributes', $attribute);
    }

    /** @test */
    public function user_cant_create_attribute_without_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.attributes.store'))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_attribute_with_integer_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_attribute_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_attribute_with_existing_name()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('admin.attributes.store'), [
                'name' => $attribute->name,
            ])->assertSessionHasErrors('name');
    }
}
