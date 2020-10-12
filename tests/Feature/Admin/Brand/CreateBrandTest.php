<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateBrandTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_brand_page()
    {
        $this->get(route('admin.brands.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_brand_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $brand = Brand::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.brands.store'), $brand)
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.created'));

        $this->assertDatabaseHas('brands', $brand);
    }

    /** @test */
    public function user_cant_create_brand_without_name()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.brands.store'))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_integer_name()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.brands.store'), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.brands.store'), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_existing_name()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.brands.store'), [
                'name' => $brand->name,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_without_currency()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->raw(['currency_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.brands.store'), $brand)
            ->assertSessionHasErrors('currency_id');
    }

    /** @test */
    public function user_cant_create_brand_with_string_currency()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->raw(['currency_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.brands.store'), $brand)
            ->assertSessionHasErrors('currency_id');
    }

    /** @test */
    public function user_cant_create_brand_with_nonexistent_currency()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->raw(['currency_id' => 1]);

        $this->actingAs($user)
            ->post(route('admin.brands.store'), $brand)
            ->assertSessionHasErrors('currency_id');
    }
}
