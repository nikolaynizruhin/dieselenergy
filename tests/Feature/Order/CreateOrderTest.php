<?php

namespace Tests\Feature\Order;

use App\Events\OrderCreated as OrderCreatedEvent;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\OrderConfirmed;
use App\Notifications\OrderCreated;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
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

        $currency = Currency::factory()->state(['rate' => 30.0000]);
        $brand = Brand::factory()->for($currency);
        $this->product = Product::factory()
            ->for($brand)
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
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
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

        $this->post(route('orders.store'), $stub->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertRedirect();

        $this->assertDatabaseHas('customers', $stub->toArray());
        $this->assertDatabaseCount('customers', 1);
    }

    /** @test */
    public function it_should_send_order_confirmation_email_to_customer()
    {
        Notification::fake();

        $stub = Customer::factory()->make()->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $stub->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ]);

        $customer = Customer::firstWhere('email', $stub->email);

        $order = $customer->orders()->first();

        Notification::assertSentTo(
            $customer,
            fn (OrderConfirmed $notification) => $notification->order->id === $order->id
        );
    }

    /** @test */
    public function it_should_send_order_created_email_to_admin()
    {
        Notification::fake();

        $stub = Customer::factory()->make()->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $stub->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ]);

        $order = Customer::firstWhere('email', $stub->email)->orders()->first();

        Notification::assertSentTo(
            new AnonymousNotifiable,
            OrderCreated::class,
            function ($notification, $channels, $notifiable) use ($order) {
                return $notifiable->routes['mail'] === config('company.email')
                    && $notification->order->id === $order->id;
            }
        );
    }

    /** @test */
    public function it_should_trigger_order_created_event()
    {
        Event::fake();

        $stub = Customer::factory()->make()->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $stub->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ]);

        Event::assertDispatched(OrderCreatedEvent::class);
    }

    /** @test */
    public function guest_cant_create_order_without_customer_name()
    {
        $customer = Customer::factory()
            ->make(['name' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_name()
    {
        $customer = Customer::factory()
            ->make(['name' => 1])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_name_more_than_255_chars()
    {
        $customer = Customer::factory()
            ->make(['name' => str_repeat('a', 256)])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_email()
    {
        $customer = Customer::factory()
            ->make(['email' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_email()
    {
        $customer = Customer::factory()
            ->make(['email' => 1])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_email_more_than_255_chars()
    {
        $customer = Customer::factory()
            ->make(['email' => str_repeat('a', 256)])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_invalid_customer_email()
    {
        $customer = Customer::factory()
            ->make(['email' => 'invalid'])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_phone()
    {
        $customer = Customer::factory()
            ->make(['phone' => null])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_incorrect_customer_phone_format()
    {
        $customer = Customer::factory()
            ->make(['phone' => 0631234567])
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_notes()
    {
        $customer = Customer::factory()
            ->make()
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            'notes' => 1,
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('notes');
    }

    /** @test */
    public function guest_cant_create_order_with_empty_cart()
    {
        $customer = Customer::factory()
            ->make()
            ->makeHidden('notes');

        $this->post(route('orders.store'), $customer->toArray() + [
            'privacy' => 1,
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('cart');
    }

    /** @test */
    public function guest_cant_create_order_without_accepting_privacy()
    {
        $customer = Customer::factory()
            ->make()
            ->makeHidden('notes');

        Cart::add($this->product);

        $this->post(route('orders.store'), $customer->toArray() + [
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ])->assertSessionHasErrors('privacy');
    }

    /** @test */
    public function guest_cant_create_order_with_spam()
    {
        $customer = Customer::factory()
            ->make()
            ->makeHidden('notes');

        Cart::add($this->product, $quantity = $this->faker->randomDigitNotNull);

        $this->post(route('orders.store'), $customer->toArray() + [
            'notes' => $notes = $this->faker->paragraph,
            'privacy' => 1,
            config('honeypot.field') => 'spam',
        ])->assertSuccessful();

        $this->assertDatabaseCount('orders', 0);
    }

    /** @test */
    public function guest_cant_create_order_too_quickly()
    {
        $customer = Customer::factory()
            ->make()
            ->makeHidden('notes');

        Cart::add($this->product, $quantity = $this->faker->randomDigitNotNull);

        $this->post(route('orders.store'), $customer->toArray() + [
            'notes' => $notes = $this->faker->paragraph,
            'privacy' => 1,
            config('honeypot.valid_from_field') => time(),
        ])->assertSuccessful();

        $this->assertDatabaseCount('orders', 0);
    }
}
