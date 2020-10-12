<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateBrandTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_brand_page()
    {
        $brand = Brand::factory()->create();

        $this->get(route('admin.brands.edit', $brand))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_brand_page()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.brands.edit', $brand))
            ->assertViewIs('admin.brands.edit')
            ->assertViewHas('brand', $brand);
    }

    /** @test */
    public function guest_cant_update_brand()
    {
        $brand = Brand::factory()->create();

        $this->put(route('admin.brands.update', $brand), [
            'name' => $this->faker->word,
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $stub = Brand::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), $stub)
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.updated'));

        $this->assertDatabaseHas('brands', $stub);
    }

    /** @test */
    public function user_cant_update_brand_without_name()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), [
                'name' => null,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_brand_with_integer_name()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_brand_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_brand_with_existing_name()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $existing = Brand::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), [
                'name' => $existing->name,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_without_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $stub = Brand::factory()->raw(['currency_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), $stub)
            ->assertSessionHasErrors('currency_id');
    }

    /** @test */
    public function user_cant_update_product_with_string_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $stub = Brand::factory()->raw(['currency_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), $stub)
            ->assertSessionHasErrors('currency_id');
    }

    /** @test */
    public function user_cant_update_product_with_nonexistent_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $stub = Brand::factory()->raw(['currency_id' => 100]);

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), $stub)
            ->assertSessionHasErrors('currency_id');
    }
}
