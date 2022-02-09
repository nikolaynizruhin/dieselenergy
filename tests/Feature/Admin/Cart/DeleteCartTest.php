<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use Tests\TestCase;

class DeleteCartTest extends TestCase
{
    /**
     * Cart.
     *
     * @var \App\Models\Cart
     */
    private $cart;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = Cart::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_cart()
    {
        $this->delete(route('admin.carts.destroy', $this->cart))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_cart()
    {
        $this->login()
            ->from(route('admin.orders.show', $this->cart->order))
            ->delete(route('admin.carts.destroy', $this->cart))
            ->assertRedirect(route('admin.orders.show', $this->cart->order))
            ->assertSessionHas('status', trans('cart.deleted'));

        $this->assertModelMissing($this->cart);
    }
}
