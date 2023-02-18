<?php

namespace Tests\Feature\Admin\Brand;

use Tests\TestCase;

class CreateBrandTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_brand_page(): void
    {
        $this->get(route('admin.brands.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_brand_page(): void
    {
        $this->login()
            ->get(route('admin.brands.create'))
            ->assertViewIs('admin.brands.create');
    }

    /** @test */
    public function guest_cant_create_brand(): void
    {
        $this->post(route('admin.brands.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_brand(): void
    {
        $this->login()
            ->post(route('admin.brands.store'), $fields = self::validFields())
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.created'));

        $this->assertDatabaseHas('brands', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_brand_with_invalid_data(string $field, callable $data, int $count = 0): void
    {
        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), $data())
            ->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('brands', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider();
    }
}
