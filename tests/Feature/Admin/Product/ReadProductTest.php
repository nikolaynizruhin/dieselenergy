<?php

namespace Tests\Feature\Admin\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_product()
    {
        $product = factory(Product::class)->create();

        $this->get(route('admin.products.show', $product))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_product()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->get(route('admin.products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('admin.products.show')
            ->assertViewHas('product')
            ->assertSee($product->name);
    }
}
