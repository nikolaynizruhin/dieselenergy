<?php

namespace Tests\Feature\Brand;

use App\Brand;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateBrandTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_brand_page()
    {
        $this->get(route('brands.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_create_brand_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('brands.create'))
            ->assertViewIs('brands.create');
    }

    /** @test */
    public function guest_cant_create_brand()
    {
        $brand = factory(Brand::class)->raw();

        $this->post(route('brands.store'), $brand)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_brand()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->raw();

        $this->actingAs($user)
            ->post(route('brands.store'), $brand)
            ->assertRedirect(route('brands.index'))
            ->assertSessionHas('status', 'Brand was created successfully!');

        $this->assertDatabaseHas('brands', $brand);
    }

    /** @test */
    public function user_cant_create_brand_without_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('brands.store'))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_integer_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('brands.store'), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('brands.store'), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_existing_name()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->post(route('brands.store'), [
                'name' => $brand->name,
            ])->assertSessionHasErrors('name');
    }
}
