<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateBrandTest extends TestCase
{
    /** @test */
    public function guest_cant_visit_create_brand_page()
    {
        $this->get(route('admin.brands.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_brand_page()
    {
        $this->login()
            ->get(route('admin.brands.create'))
            ->assertViewIs('admin.brands.create');
    }

    /** @test */
    public function guest_cant_create_brand()
    {
        $this->post(route('admin.brands.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_brand()
    {
        $this->login()
            ->post(route('admin.brands.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.created'));

        $this->assertDatabaseHas('brands', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_brand_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), $data())
            ->assertRedirect(route('admin.brands.create'))
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
                'name', fn () => $this->validFields(['name' => Brand::factory()->create()->name]), 1,
            ],
            'Currency is required' => [
                'currency_id', fn () => $this->validFields(['currency_id' => null]),
            ],
            'Currency cant be string' => [
                'currency_id', fn () => $this->validFields(['currency_id' => 'string']),
            ],
            'Currency must exists' => [
                'currency_id', fn () => $this->validFields(['currency_id' => 1]),
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
