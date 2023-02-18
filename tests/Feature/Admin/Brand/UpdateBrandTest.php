<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Tests\TestCase;

class UpdateBrandTest extends TestCase
{
    use HasValidation;

    /**
     * Brand.
     */
    private Brand $brand;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->brand = Brand::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_brand_page(): void
    {
        $this->get(route('admin.brands.edit', $this->brand))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_brand_page(): void
    {
        $this->login()
            ->get(route('admin.brands.edit', $this->brand))
            ->assertViewIs('admin.brands.edit')
            ->assertViewHas('brand', $this->brand);
    }

    /** @test */
    public function guest_cant_update_brand(): void
    {
        $this->put(route('admin.brands.update', $this->brand), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_brand(): void
    {
        $this->login()
            ->put(route('admin.brands.update', $this->brand), $fields = self::validFields())
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.updated'));

        $this->assertDatabaseHas('brands', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_update_brand_with_invalid_data(string $field, callable $data, $count = 1): void
    {
        $this->login()
            ->from(route('admin.brands.edit', $this->brand))
            ->put(route('admin.brands.update', $this->brand), $data())
            ->assertRedirect(route('admin.brands.edit', $this->brand))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('brands', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider(2);
    }
}
