<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    use HasValidation;

    /**
     * Cart.
     */
    private Cart $cart;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = Cart::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_cart_page(): void
    {
        $this->get(route('admin.carts.edit', $this->cart))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_cart_page(): void
    {
        $this->login()
            ->get(route('admin.carts.edit', $this->cart))
            ->assertSuccessful()
            ->assertViewIs('admin.carts.edit')
            ->assertViewHas(['cart', 'products']);
    }

    /** @test */
    public function guest_cant_update_cart(): void
    {
        $this->put(route('admin.carts.update', $this->cart), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_cart(): void
    {
        $this->login()
            ->put(route('admin.carts.update', $this->cart), $fields = self::validFields())
            ->assertRedirect(route('admin.orders.show', $fields['order_id']))
            ->assertSessionHas('status', trans('cart.updated'));

        $this->assertDatabaseHas('order_product', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_update_cart_with_invalid_data(string $field, callable $data, int $count = 1): void
    {
        $this->login()
            ->from(route('admin.carts.edit', $this->cart))
            ->put(route('admin.carts.update', $this->cart), $data())
            ->assertRedirect(route('admin.carts.edit', $this->cart))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('order_product', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider(2);
    }
}
