<?php

namespace Tests\Feature\Admin\Attribute;

use Tests\TestCase;

class CreateAttributeTest extends TestCase
{
    use HasValidation;

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
        $this->post(route('admin.attributes.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_attribute()
    {
        $this->login()
            ->post(route('admin.attributes.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.created'));

        $this->assertDatabaseHas('attributes', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_attribute_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $data())
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('attributes', $count);
    }

    public function validationProvider(): array
    {
        return $this->provider();
    }
}
