<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateBrandTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\Brand
     */
    private $brand;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->brand = Brand::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_brand_page()
    {
        $this->get(route('admin.brands.edit', $this->brand))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_brand_page()
    {
        $this->login()
            ->get(route('admin.brands.edit', $this->brand))
            ->assertViewIs('admin.brands.edit')
            ->assertViewHas('brand', $this->brand);
    }

    /** @test */
    public function guest_cant_update_brand()
    {
        $this->put(route('admin.brands.update', $this->brand), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_brand()
    {
        $this->login()
            ->put(route('admin.brands.update', $this->brand), $fields = $this->validFields())
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.updated'));

        $this->assertDatabaseHas('brands', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_brand_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.brands.edit', $this->brand))
            ->put(route('admin.brands.update', $this->brand), $data())
            ->assertRedirect(route('admin.brands.edit', $this->brand))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('brands', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Name must be unique' => [
                'name', fn () => $this->validFields(['name' => Brand::factory()->create()->name]), 2,
            ],
            'Currency is required' => [
                'currency_id', fn () => $this->validFields(['currency_id' => null]),
            ],
            'Currency cant be string' => [
                'currency_id', fn () => $this->validFields(['currency_id' => 'string']),
            ],
            'Currency must exists' => [
                'currency_id', fn () => $this->validFields(['currency_id' => 10]),
            ],
        ];
    }

    /**
     * Get valid brand fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Brand::factory()->raw($overrides);
    }
}
