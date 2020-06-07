<?php

namespace Tests\Feature\Admin\Brand;

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
        $this->get(route('admin.brands.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_brand_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.brands.create'))
            ->assertViewIs('admin.brands.create');
    }

    /** @test */
    public function guest_cant_create_brand()
    {
        $brand = factory(Brand::class)->raw();

        $this->post(route('admin.brands.store'), $brand)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_brand()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->raw();

        $this->actingAs($user)
            ->post(route('admin.brands.store'), $brand)
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.created'));

        $this->assertDatabaseHas('brands', $brand);
    }

    /** @test */
    public function user_cant_create_brand_without_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.brands.store'))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_integer_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.brands.store'), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.brands.store'), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_brand_with_existing_name()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->post(route('admin.brands.store'), [
                'name' => $brand->name,
            ])->assertSessionHasErrors('name');
    }
}
