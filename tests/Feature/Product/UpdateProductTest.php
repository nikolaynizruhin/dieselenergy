<?php

namespace Tests\Feature\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_product_page()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.edit', $product))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_update_product_page()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->get(route('products.edit', $product))
            ->assertViewIs('products.edit')
            ->assertViewHas('product', $product);
    }

    /** @test */
    public function guest_cant_update_product()
    {
        $product = factory(Product::class)->create();

        $this->put(route('products.update', $product), [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_update_product()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw();

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('status', 'Product was updated successfully!');

        $this->assertDatabaseHas('products', $stub);
    }

    /** @test */
    public function user_cant_update_product_without_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['name' => null]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_with_integer_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['name' => 1]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw([
            'name' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_without_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['price' => null]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_with_string_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['price' => 'string']);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_with_zero_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['price' => 0]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_without_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['brand_id' => null]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_with_string_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['brand_id' => 'string']);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_with_nonexistent_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['brand_id' => 100]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_without_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['category_id' => null]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_product_with_string_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['category_id' => 'string']);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_product_with_nonexistent_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['category_id' => 100]);

        $this->actingAs($user)
            ->put(route('products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

}
