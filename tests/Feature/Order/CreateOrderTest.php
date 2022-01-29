<?php

namespace Tests\Feature\Order;

use App\Enums\OrderStatus;
use App\Events\OrderCreated as OrderCreatedEvent;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\OrderConfirmed;
use App\Notifications\OrderCreated;
use Facades\App\Services\Cart;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\Honeypot;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use WithFaker, Honeypot;

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
            'status' => OrderStatus::New,
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

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function guest_cant_create_order_with_invalid_data($field, $data)
    {
        $this->post(route('orders.store'), $data())
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('customers', 0);
    }

    public function validationProvider(): array
    {
        return [
            'Privacy is required' => [
                'privacy', fn () => $this->validFields(['privacy' => null]),
            ],
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Email is required' => [
                'email', fn () => $this->validFields(['email' => null]),
            ],
            'Email cant be an integer' => [
                'email', fn () => $this->validFields(['email' => 1]),
            ],
            'Email cant be more than 255 chars' => [
                'email', fn () => $this->validFields(['email' => Str::random(256)]),
            ],
            'Email must be valid' => [
                'email', fn () => $this->validFields(['email' => 'invalid']),
            ],
            'Phone is required' => [
                'phone', fn () => $this->validFields(['phone' => null]),
            ],
            'Phone must have valid format' => [
                'phone', fn () => $this->validFields(['phone' => 0631234567]),
            ],
            'Notes cant be an integer' => [
                'notes', fn () => $this->validFields(['notes' => 1]),
            ],
            'Cart cant be empty' => [
                'cart', function () {
                    Cart::clear();

                    return $this->validFields();
                },
            ],
        ];
    }

    /**
     * @test
     * @dataProvider spamProvider
     */
    public function guest_cant_create_order_with_spam($data)
    {
        $this->post(route('orders.store'), $data())
            ->assertSuccessful();

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('customers', 0);
    }

    public function spamProvider()
    {
        return [
            'Order cant contain spam' => [
                fn () => $this->validFields([config('honeypot.field') => 'spam']),
            ],
            'Order cant be created too quickly' => [
                fn () => $this->validFields([config('honeypot.valid_from_field') => time()]),
            ],
        ];
    }

    /**
     * Get valid order fields.
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
            'notes' => $customer->notes,
        ] + $this->honeypot(), $overrides);
    }
}
