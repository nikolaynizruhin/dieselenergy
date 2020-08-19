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
        $customer = factory(Customer::class)->make()->makeHidden('notes');

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
        $customer = factory(Customer::class)->raw(['name' => null]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_name()
    {
        $customer = factory(Customer::class)->raw(['name' => 1]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_name_more_than_255_chars()
    {
        $customer = factory(Customer::class)->raw([
            'name' => str_repeat('a', 256),
        ]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_email()
    {
        $customer = factory(Customer::class)->raw(['email' => null]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_email()
    {
        $customer = factory(Customer::class)->raw(['email' => 1]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_email_more_than_255_chars()
    {
        $customer = factory(Customer::class)->raw([
            'email' => str_repeat('a', 256),
        ]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_invalid_customer_email()
    {
        $customer = factory(Customer::class)->raw(['email' => 'invalid']);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_phone()
    {
        $customer = factory(Customer::class)->raw(['phone' => null]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_phone()
    {
        $customer = factory(Customer::class)->raw(['phone' => 1]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_phone_more_than_255_chars()
    {
        $customer = factory(Customer::class)->raw([
            'phone' => str_repeat('a', 256),
        ]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_notes()
    {
        $customer = factory(Customer::class)->raw(['notes' => 1]);

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer)
            ->assertSessionHasErrors('notes');
    }
}
