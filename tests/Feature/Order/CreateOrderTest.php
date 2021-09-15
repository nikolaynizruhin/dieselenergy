<?php

namespace Tests\Feature\Order;

use App\Events\OrderCreated as OrderCreatedEvent;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\Customer;
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
use Tests\Honeypot;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker, Honeypot;

    /**
     * Product.
     *
     * @var \App\Models\Product
     */
    private $product;

    /**
     * Amount of products in the cart.
     *
     * @var int
     */
    private $quantity;

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
            ->withDefaultImage()
            ->create();

        Cart::add($this->product, $this->quantity = $this->faker->randomDigitNotNull());
    }

    /** @test */
    public function guest_can_create_order()
    {
        $total = Cart::total();

        $this->post(route('orders.store'), $fields = $this->validFields())
            ->assertRedirect(route('orders.show', Order::first()));

        $this->assertDatabaseHas('customers', [
            'name' => $fields['name'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
        ]);

        $this->assertDatabaseHas('order_product', [
            'product_id' => $this->product->id,
            'quantity' => $this->quantity,
        ]);

        $this->assertDatabaseHas('orders', [
            'status' => Order::NEW,
            'total' => $total,
            'notes' => $fields['notes'],
        ]);

        $this->assertTrue(Cart::items()->isEmpty());
    }

    /** @test */
    public function it_should_update_existing_customer()
    {
        $customer = Customer::factory()->create();

        $this->post(route('orders.store'), $fields = $this->validFields(['email' => $customer->email]))
            ->assertRedirect();

        $this->assertDatabaseHas('customers', [
            'name' => $fields['name'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
        ]);

        $this->assertDatabaseCount('customers', 1);
    }

    /** @test */
    public function it_should_send_order_confirmation_email_to_customer()
    {
        Notification::fake();

        $this->post(route('orders.store'), $fields = $this->validFields());

        $customer = Customer::firstWhere('email', $fields['email']);

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

        $this->post(route('orders.store'), $fields = $this->validFields());

        $order = Customer::firstWhere('email', $fields['email'])->orders()->first();

        Notification::assertSentTo(
            new AnonymousNotifiable,
            OrderCreated::class,
            fn ($notification, $channels, $notifiable) => $notifiable->routes['mail'] === config('company.email')
                && $notification->order->id === $order->id
        );
    }

    /** @test */
    public function it_should_trigger_order_created_event()
    {
        Event::fake();

        $this->post(route('orders.store'), $this->validFields());

        Event::assertDispatched(OrderCreatedEvent::class);
    }

    /** @test */
    public function guest_cant_create_order_without_customer_name()
    {
        $this->post(route('orders.store'), $this->validFields(['name' => null]))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_name()
    {
        $this->post(route('orders.store'), $this->validFields(['name' => 1]))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_name_more_than_255_chars()
    {
        $this->post(route('orders.store'), $this->validFields([
            'name' => str_repeat('a', 256),
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_email()
    {
        $this->post(route('orders.store'), $this->validFields(['email' => null]))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_customer_email()
    {
        $this->post(route('orders.store'), $this->validFields(['email' => 1]))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_customer_email_more_than_255_chars()
    {
        $this->post(route('orders.store'), $this->validFields([
            'email' => str_repeat('a', 256),
        ]))->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_with_invalid_customer_email()
    {
        $this->post(route('orders.store'), $this->validFields(['email' => 'invalid']))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_order_without_customer_phone()
    {
        $this->post(route('orders.store'), $this->validFields(['phone' => null]))
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_incorrect_customer_phone_format()
    {
        $this->post(route('orders.store'), $this->validFields(['phone' => 0631234567]))
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_order_with_integer_notes()
    {
        $this->post(route('orders.store'), $this->validFields(['notes' => 1]))
            ->assertSessionHasErrors('notes');
    }

    /** @test */
    public function guest_cant_create_order_with_empty_cart()
    {
        Cart::clear();

        $this->post(route('orders.store'), $this->validFields())
            ->assertSessionHasErrors('cart');
    }

    /** @test */
    public function guest_cant_create_order_without_accepting_privacy()
    {
        $this->post(route('orders.store'), $this->validFields(['privacy' => null]))
            ->assertSessionHasErrors('privacy');
    }

    /** @test */
    public function guest_cant_create_order_with_spam()
    {
        $this->post(route('orders.store'), $this->validFields([
            config('honeypot.field') => 'spam',
        ]))->assertSuccessful();

        $this->assertDatabaseCount('orders', 0);
    }

    /** @test */
    public function guest_cant_create_order_too_quickly()
    {
        $this->post(route('orders.store'), $this->validFields([
            config('honeypot.valid_from_field') => time(),
        ]))->assertSuccessful();

        $this->assertDatabaseCount('orders', 0);
    }

    /**
     * Get valid contact fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        $customer = Customer::factory()->make();

        return array_merge([
            'privacy' => 1,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'notes' => $this->faker->paragraph(),
        ] + $this->honeypot(), $overrides);
    }
}
