<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateBrandTest extends TestCase
{
    use WithFaker;

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
        $brand = Brand::factory()->raw();

        $this->post(route('admin.brands.store'), $brand)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_brand()
    {
        $brand = Brand::factory()->raw();

        $this->login()
            ->post(route('admin.brands.store'), $brand)
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.created'));

        $this->assertDatabaseHas('brands', $brand);
    }

    /** @test */
    public function user_cant_create_brand_without_name()
    {
        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'))
            ->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function user_cant_create_brand_with_integer_name()
    {
        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), [
                'name' => 1,
            ])->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function user_cant_create_brand_with_name_more_than_255_chars()
    {
        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), [
                'name' => str_repeat('a', 256),
            ])->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function user_cant_create_brand_with_existing_name()
    {
        $brand = Brand::factory()->create();

        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), [
                'name' => $brand->name,
            ])->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('brands', 1);
    }

    /** @test */
    public function user_cant_create_brand_without_currency()
    {
        $brand = Brand::factory()->raw(['currency_id' => null]);

        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), $brand)
            ->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors('currency_id');

        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function user_cant_create_brand_with_string_currency()
    {
        $brand = Brand::factory()->raw(['currency_id' => 'string']);

        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), $brand)
            ->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors('currency_id');

        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function user_cant_create_brand_with_nonexistent_currency()
    {
        $brand = Brand::factory()->raw(['currency_id' => 1]);

        $this->login()
            ->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), $brand)
            ->assertRedirect(route('admin.brands.create'))
            ->assertSessionHasErrors('currency_id');

        $this->assertDatabaseCount('brands', 0);
    }
}
