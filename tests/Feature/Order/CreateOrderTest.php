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
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\Honeypot;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use Honeypot;

    /**
     * Product.
     */
    private Product $product;

    /**
     * Amount of products in the cart.
     */
    private int $quantity;

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

        Cart::add($this->product, $this->quantity = fake()->randomDigitNotNull());
    }

    /** @test */
    public function guest_can_create_order(): void
    {
        $total = Cart::total();

        $this->post(route('orders.store'), $fields = self::validFields())
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
    public function it_should_update_existing_customer(): void
    {
        $customer = Customer::factory()->create();

        $this->post(route('orders.store'), $fields = self::validFields(['email' => $customer->email]))
            ->assertRedirect();

        $this->assertDatabaseHas('customers', [
            'name' => $fields['name'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
        ]);

        $this->assertDatabaseCount('customers', 1);
    }

    /** @test */
    public function it_should_send_order_confirmation_email_to_customer(): void
    {
        Notification::fake();

        $this->post(route('orders.store'), $fields = self::validFields());

        $customer = Customer::firstWhere('email', $fields['email']);

        $order = $customer->orders()->first();

        Notification::assertSentTo(
            $customer,
            fn (OrderConfirmed $notification) => $notification->order->id === $order->id
        );
    }

    /** @test */
    public function it_should_send_order_created_email_to_admin(): void
    {
        Notification::fake();

        $this->post(route('orders.store'), $fields = self::validFields());

        $order = Customer::firstWhere('email', $fields['email'])->orders()->first();

        Notification::assertSentTo(
            new AnonymousNotifiable,
            OrderCreated::class,
            fn ($notification, $channels, $notifiable) => $notifiable->routes['mail'] === config('company.email')
                && $notification->order->id === $order->id
        );
    }

    /** @test */
    public function it_should_trigger_order_created_event(): void
    {
        Event::fake();

        $this->post(route('orders.store'), self::validFields());

        Event::assertDispatched(OrderCreatedEvent::class);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function guest_cant_create_order_with_invalid_data(string $field, callable $data)
    {
        $this->post(route('orders.store'), $data())
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('customers', 0);
    }

    public static function validationProvider(): array
    {
        return [
            'Privacy is required' => [
                'privacy', fn () => self::validFields(['privacy' => null]),
            ],
            'Name is required' => [
                'name', fn () => self::validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => self::validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => self::validFields(['name' => Str::random(256)]),
            ],
            'Email is required' => [
                'email', fn () => self::validFields(['email' => null]),
            ],
            'Email cant be an integer' => [
                'email', fn () => self::validFields(['email' => 1]),
            ],
            'Email cant be more than 255 chars' => [
                'email', fn () => self::validFields(['email' => Str::random(256)]),
            ],
            'Email must be valid' => [
                'email', fn () => self::validFields(['email' => 'invalid']),
            ],
            'Phone is required' => [
                'phone', fn () => self::validFields(['phone' => null]),
            ],
            'Phone must have valid format' => [
                'phone', fn () => self::validFields(['phone' => 0631234567]),
            ],
            'Notes cant be an integer' => [
                'notes', fn () => self::validFields(['notes' => 1]),
            ],
            'Cart cant be empty' => [
                'cart', function () {
                    Cart::clear();

                    return self::validFields();
                },
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider spamProvider
     */
    public function guest_cant_create_order_with_spam($data): void
    {
        $this->post(route('orders.store'), $data())
            ->assertSuccessful();

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('customers', 0);
    }

    public static function spamProvider(): array
    {
        return [
            'Order cant contain spam' => [
                fn () => self::validFields([config('honeypot.field') => 'spam']),
            ],
            'Order cant be created too quickly' => [
                fn () => self::validFields([config('honeypot.valid_from_field') => time()]),
            ],
        ];
    }

    /**
     * Get valid order fields.
     */
    private static function validFields(array $overrides = []): array
    {
        $customer = Customer::factory()->make();

        return array_merge([
            'privacy' => 1,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'notes' => $customer->notes,
        ] + self::honeypot(), $overrides);
    }
}
