<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use Tests\TestCase;

class ReadProductTest extends TestCase
{
    /** @test */
    public function guest_cant_read_product(): void
    {
        $product = Product::factory()->create();

        $this->get(route('admin.products.show', $product))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_product(): void
    {
        $product = Product::factory()->create();

        $this->login()
            ->get(route('admin.products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('admin.products.show')
            ->assertViewHas('product')
            ->assertSee($product->name);
    }
}
