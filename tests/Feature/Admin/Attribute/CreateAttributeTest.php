<?php

namespace Tests\Feature\Admin\Attribute;

use Tests\TestCase;

class CreateAttributeTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_attribute_page(): void
    {
        $this->get(route('admin.attributes.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_attribute_page(): void
    {
        $this->login()
            ->get(route('admin.attributes.create'))
            ->assertViewIs('admin.attributes.create');
    }

    /** @test */
    public function guest_cant_create_attribute(): void
    {
        $this->post(route('admin.attributes.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_attribute(): void
    {
        $this->login()
            ->post(route('admin.attributes.store'), $fields = self::validFields())
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.created'));

        $this->assertDatabaseHas('attributes', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_attribute_with_invalid_data(string $field, callable $data, int $count = 0): void
    {
        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $data())
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('attributes', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider();
    }
}
