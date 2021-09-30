<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{


    /** @test */
    public function guest_cant_delete_product()
    {
        $product = Product::factory()->create();

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_product()
    {
        $product = Product::factory()->create();

        $this->login()
            ->from(route('admin.products.index'))
            ->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.deleted'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
