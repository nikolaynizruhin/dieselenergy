<?php

namespace Tests\Feature\Order;

use App\Customer;
use App\Image;
use App\Order;
use App\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Product.
     *
     * @var \App\Product
     */
    private $product;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = factory(Product::class)->create();

        $image = factory(Image::class)->create();

        $this->product->images()->attach($image, ['is_default' => 1]);
    }

    /** @test */
    public function guest_can_create_order()
    {
        $customer = factory(Customer::class)
            ->make()
            ->makeHidden('notes');

        Cart::add($this->product, $quantity = $this->faker->randomDigitNotNull);

        $total = Cart::total();

        $this->post(route('orders.store'), $customer->toArray() + [
                'notes' => $notes = $this->faker->paragraph,
            ])->assertRedirect();

        $this->assertDatabaseHas('customers', $customer->toArray());

        $this->assertDatabaseHas('order_product', [
            'product_id' => $this->product->id,
            'quantity' => $quantity
        ]);

        $this->assertDatabaseHas('orders', [
            'status' => Order::NEW,
            'total' => $total,
            'notes' => $notes,
        ]);

        $this->assertTrue(Cart::items()->isEmpty());
    }

    /** @test */
    public function guest_cant_create_order_without_customer_name()
    {
        $customer = factory(Customer::class)
            ->make(['name' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_name()
    {
        $customer = factory(Customer::class)
            ->make(['name' => 1])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_name_more_than_255_chars()
    {
        $customer = factory(Customer::class)
            ->make(['name' => str_repeat('a', 256)])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_email()
    {
        $customer = factory(Customer::class)
            ->make(['email' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_email()
    {
        $customer = factory(Customer::class)
            ->make(['email' => 1])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_email_more_than_255_chars()
    {
        $customer = factory(Customer::class)
            ->make(['email' => str_repeat('a', 256)])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_invalid_customer_email()
    {
        $customer = factory(Customer::class)
            ->make(['email' => 'invalid'])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_phone()
    {
        $customer = factory(Customer::class)
            ->make(['phone' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_phone()
    {
        $customer = factory(Customer::class)
            ->make(['phone' => 1])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_phone_more_than_255_chars()
    {
        $customer = factory(Customer::class)
            ->make(['phone' => str_repeat('a', 256)])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_notes()
    {
        $customer = factory(Customer::class)
            ->make()
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + ['notes' => 1])
            ->assertSessionHasErrors('notes');
    }

    /** @test */
    public function guest_cant_create_order_with_empty_cart()
    {
        $customer = factory(Customer::class)
            ->make()
            ->makeHidden('notes');

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('cart');
    }
}
