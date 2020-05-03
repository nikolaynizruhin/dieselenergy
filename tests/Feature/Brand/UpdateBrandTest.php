<?php

namespace Tests\Feature\Brand;

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

        $this->get(route('brands.edit', $brand))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_update_brand_page()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->get(route('brands.edit', $brand))
            ->assertViewIs('brands.edit')
            ->assertViewHas('brand', $brand);
    }

    /** @test */
    public function guest_cant_update_brand()
    {
        $brand = factory(Brand::class)->create();

        $this->put(route('brands.update', $brand), [
            'name' => $this->faker->word,
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_update_brand()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();
        $stub = factory(Brand::class)->raw();

        $this->actingAs($user)
            ->put(route('brands.update', $brand), $stub)
            ->assertRedirect(route('brands.index'))
            ->assertSessionHas('status', 'Brand was updated successfully!');

        $this->assertDatabaseHas('brands', $stub);
    }

    /** @test */
    public function user_cant_update_brand_without_name()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->put(route('brands.update', $brand), [
                'name' => null,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_brand_with_integer_name()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->put(route('brands.update', $brand), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_brand_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->put(route('brands.update', $brand), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }
}
