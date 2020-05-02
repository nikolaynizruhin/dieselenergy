<?php

namespace Tests\Feature\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_product_page()
    {
        $this->get(route('products.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_create_product_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('products.create'))
            ->assertViewIs('products.create');
    }

    /** @test */
    public function guest_cant_create_product()
    {
        $product = factory(Product::class)->raw();

        $this->post(route('products.store'), $product)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_product()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw();

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('status', 'Product was created successfully!');

        $this->assertDatabaseHas('products', $product);
    }

    /** @test */
    public function user_cant_create_product_without_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['name' => null]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_integer_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['name' => 1]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw([
            'name' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_integer_description()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['description' => 1]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_cant_create_product_without_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['price' => null]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_create_product_with_string_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['price' => 'string']);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_create_product_with_zero_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['price' => 0]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('price');
    }
}
