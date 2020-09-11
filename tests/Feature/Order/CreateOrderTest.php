<?php

namespace Tests\Feature\Order;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\OrderConfirmed;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Product.
     *
     * @var \App\Models\Product
     */
    private $product;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->create();
    }

    /** @test */
    public function guest_can_create_order()
    {
        $customer = Customer::factory()
            ->make()
            ->makeHidden('notes');

        Cart::add($this->product, $quantity = $this->faker->randomDigitNotNull);

        $total = Cart::total();

        $response = $this->post(route('orders.store'), $customer->toArray() + [
            'notes' => $notes = $this->faker->paragraph,
        ]);

        $response->assertRedirect(route('orders.show', Order::first()));

        $this->assertDatabaseHas('customers', $customer->toArray());

        $this->assertDatabaseHas('order_product', [
            'product_id' => $this->product->id,
            'quantity' => $quantity,
        ]);

        $this->assertDatabaseHas('orders', [
            'status' => Order::NEW,
            'total' => $total,
            'notes' => $notes,
        ]);

        $this->assertTrue(Cart::items()->isEmpty());
    }

    /** @test */
    public function it_should_update_existing_customer()
    {
        $customer = Customer::factory()->create();
        $stub = Customer::factory()
            ->make(['email' => $customer->email])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $stub->toArray())
            ->assertRedirect();

        $this->assertDatabaseHas('customers', $stub->toArray());
        $this->assertDatabaseCount('customers', 1);
    }

    /** @test */
    public function it_should_send_order_confirmation_email_to_customer()
    {
        Notification::fake();

        $stub = Customer::factory()->make()->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $stub->toArray());

        $customer = Customer::firstWhere('email', $stub->email);

        $order = $customer->orders()->first();

        Notification::assertSentTo(
            $customer,
            fn (OrderConfirmed $notification) => $notification->order->id === $order->id
        );
    }

    /** @test */
    public function guest_cant_create_order_without_customer_name()
    {
        $customer = Customer::factory()
            ->make(['name' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_name()
    {
        $customer = Customer::factory()
            ->make(['name' => 1])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_name_more_than_255_chars()
    {
        $customer = Customer::factory()
            ->make(['name' => str_repeat('a', 256)])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_email()
    {
        $customer = Customer::factory()
            ->make(['email' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_email()
    {
        $customer = Customer::factory()
            ->make(['email' => 1])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_email_more_than_255_chars()
    {
        $customer = Customer::factory()
            ->make(['email' => str_repeat('a', 256)])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_invalid_customer_email()
    {
        $customer = Customer::factory()
            ->make(['email' => 'invalid'])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_phone()
    {
        $customer = Customer::factory()
            ->make(['phone' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_phone()
    {
        $customer = Customer::factory()
            ->make(['phone' => 1])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_phone_more_than_255_chars()
    {
        $customer = Customer::factory()
            ->make(['phone' => str_repeat('a', 256)])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_notes()
    {
        $customer = Customer::factory()
            ->make()
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + ['notes' => 1])
            ->assertSessionHasErrors('notes');
    }

    /** @test */
    public function guest_cant_create_order_with_empty_cart()
    {
        $customer = Customer::factory()
            ->make()
            ->makeHidden('notes');

        $this->post(route('orders.store'), $customer->toArray())
            ->assertSessionHasErrors('cart');
    }
}
