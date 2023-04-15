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

beforeEach(function () {
    $currency = Currency::factory()->state(['rate' => 30.0000]);
    $brand = Brand::factory()->for($currency);
    $this->product = Product::factory()
        ->for($brand)
        ->withDefaultImage()
        ->create();

    Cart::add($this->product, $this->quantity = fake()->randomDigitNotNull());
});

test('guest can create order', function () {
    $total = Cart::total();

    $this->post(route('orders.store'), $fields = validFields())
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
});

test('it should update existing customer', function () {
    $customer = Customer::factory()->create();

    $this->post(route('orders.store'), $fields = validFields(['email' => $customer->email]))
        ->assertRedirect();

    $this->assertDatabaseHas('customers', [
        'name' => $fields['name'],
        'phone' => $fields['phone'],
        'email' => $fields['email'],
    ]);

    $this->assertDatabaseCount('customers', 1);
});

test('it should send order confirmation email to customer', function () {
    Notification::fake();

    $this->post(route('orders.store'), $fields = validFields());

    $customer = Customer::firstWhere('email', $fields['email']);

    $order = $customer->orders()->first();

    Notification::assertSentTo(
        $customer,
        fn (OrderConfirmed $notification) => $notification->order->id === $order->id
    );
});

test('it should send order created email to admin', function () {
    Notification::fake();

    $this->post(route('orders.store'), $fields = validFields());

    $order = Customer::firstWhere('email', $fields['email'])->orders()->first();

    Notification::assertSentTo(
        new AnonymousNotifiable,
        OrderCreated::class,
        fn ($notification, $channels, $notifiable) => $notifiable->routes['mail'] === config('company.email')
            && $notification->order->id === $order->id
    );
});

test('it should trigger order created event', function () {
    Event::fake();

    $this->post(route('orders.store'), validFields());

    Event::assertDispatched(OrderCreatedEvent::class);
});

test('guest cant create order with invalid data', function (string $field, callable $data) {
    $this->post(route('orders.store'), $data())
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('orders', 0);
    $this->assertDatabaseCount('customers', 0);
})->with([
    'Privacy is required' => [
        'privacy', fn () => validFields(['privacy' => null]),
    ],
    'Name is required' => [
        'name', fn () => validFields(['name' => null]),
    ],
    'Name cant be an integer' => [
        'name', fn () => validFields(['name' => 1]),
    ],
    'Name cant be more than 255 chars' => [
        'name', fn () => validFields(['name' => Str::random(256)]),
    ],
    'Email is required' => [
        'email', fn () => validFields(['email' => null]),
    ],
    'Email cant be an integer' => [
        'email', fn () => validFields(['email' => 1]),
    ],
    'Email cant be more than 255 chars' => [
        'email', fn () => validFields(['email' => Str::random(256)]),
    ],
    'Email must be valid' => [
        'email', fn () => validFields(['email' => 'invalid']),
    ],
    'Phone is required' => [
        'phone', fn () => validFields(['phone' => null]),
    ],
    'Phone must have valid format' => [
        'phone', fn () => validFields(['phone' => 0631234567]),
    ],
    'Notes cant be an integer' => [
        'notes', fn () => validFields(['notes' => 1]),
    ],
    'Cart cant be empty' => [
        'cart', function () {
            Cart::clear();

            return validFields();
        },
    ],
]);

test('guest cant create order with spam', function (callable $data) {
    $this->post(route('orders.store'), $data())
        ->assertSuccessful();

    $this->assertDatabaseCount('orders', 0);
    $this->assertDatabaseCount('customers', 0);
})->with([
    'Order cant contain spam' => [
        fn () => validFields([config('honeypot.field') => 'spam']),
    ],
    'Order cant be created too quickly' => [
        fn () => validFields([config('honeypot.valid_from_field') => time()]),
    ],
]);

function validFields(array $overrides = []): array
{
    $customer = Customer::factory()->make();

    return array_merge([
        'privacy' => 1,
        'name' => $customer->name,
        'email' => $customer->email,
        'phone' => $customer->phone,
        'notes' => $customer->notes,
    ] + honeypot(), $overrides);
}
