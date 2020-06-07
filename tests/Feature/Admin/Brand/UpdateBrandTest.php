<?php

namespace Tests\Feature\Admin\Brand;

use App\Brand;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateBrandTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_brand_page()
    {
        $brand = factory(Brand::class)->create();

        $this->get(route('admin.brands.edit', $brand))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_brand_page()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->get(route('admin.brands.edit', $brand))
            ->assertViewIs('admin.brands.edit')
            ->assertViewHas('brand', $brand);
    }

    /** @test */
    public function guest_cant_update_brand()
    {
        $brand = factory(Brand::class)->create();

        $this->put(route('admin.brands.update', $brand), [
            'name' => $this->faker->word,
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_brand()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();
        $stub = factory(Brand::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), $stub)
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.updated'));

        $this->assertDatabaseHas('brands', $stub);
    }

    /** @test */
    public function user_cant_update_brand_without_name()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), [
                'name' => null,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_brand_with_integer_name()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_brand_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_brand_with_existing_name()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();
        $existing = factory(Brand::class)->create();

        $this->actingAs($user)
            ->put(route('admin.brands.update', $brand), [
                'name' => $existing->name,
            ])->assertSessionHasErrors('name');
    }
}
