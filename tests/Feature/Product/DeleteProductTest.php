<?php

namespace Tests\Feature\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_product()
    {
        $product = factory(Product::class)->create();

        $this->delete(route('products.destroy', $product))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_product()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->from(route('products.index'))
            ->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('status', 'Product was deleted successfully!');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
