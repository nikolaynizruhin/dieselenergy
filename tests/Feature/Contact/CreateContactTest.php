<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use App\Notifications\ContactCreated;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\Honeypot;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use Honeypot;

    /** @test */
    public function guest_can_create_contact(): void
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $fields = self::validFields())
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHas('status', trans('contact.created'));

        $this->assertDatabaseHas('customers', [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
        ]);

        $this->assertDatabaseHas('contacts', ['message' => $fields['message']]);
    }

    /** @test */
    public function admin_should_receive_an_email_when_contact_created(): void
    {
        Notification::fake();

        $this->from(route('home'))
            ->post(route('contacts.store'), $fields = self::validFields())
            ->assertRedirect(route('home').'#contact');

        Notification::assertSentTo(
            new AnonymousNotifiable,
            ContactCreated::class,
            fn ($notification, $channels) => $notification->contact->customer->email === $fields['email'],
        );
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function guest_cant_create_contact_with_invalid_data(string $field, callable $data)
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $data())
            ->assertRedirect(route('home').'#contact')
            ->assertInvalid($field);

        $this->assertDatabaseCount('contacts', 0);
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
            'Message cant be an integer' => [
                'message', fn () => self::validFields(['message' => 1]),
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider spamProvider
     */
    public function guest_cant_create_contact_with_spam($data): void
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $data())
            ->assertSuccessful();

        $this->assertDatabaseCount('contacts', 0);
    }

    public static function spamProvider(): array
    {
        return [
            'Contact cant contain spam' => [
                fn () => self::validFields([config('honeypot.field') => 'spam']),
            ],
            'Contact cant be created too quickly' => [
                fn () => self::validFields([config('honeypot.valid_from_field') => time()]),
            ],
        ];
    }

    /**
     * Get valid contact fields.
     */
    private static function validFields(array $overrides = []): array
    {
        $contact = Contact::factory()->make();

        return array_merge([
            'privacy' => 1,
            'name' => $contact->customer->name,
            'email' => $contact->customer->email,
            'phone' => $contact->customer->phone,
            'message' => $contact->message,
        ] + self::honeypot(), $overrides);
    }
}
