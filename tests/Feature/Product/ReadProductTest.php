<?php

namespace Tests\Feature\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_product()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.show', $product))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_category()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->get(route('products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('products.show')
            ->assertViewHas('product')
            ->assertSee($product->name);
    }
}
