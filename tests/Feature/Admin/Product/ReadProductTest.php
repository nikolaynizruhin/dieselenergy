<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductTest extends TestCase
{


    /** @test */
    public function guest_cant_read_product()
    {
        $product = Product::factory()->create();

        $this->get(route('admin.products.show', $product))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_product()
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
