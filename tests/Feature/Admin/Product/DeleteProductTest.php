<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

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
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->from(route('admin.products.index'))
            ->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.deleted'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
