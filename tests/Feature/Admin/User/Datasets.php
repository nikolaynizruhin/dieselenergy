<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Str;

dataset('create_user', provider() + passwordProvider());
dataset('update_user', provider());
dataset('update_password', passwordProvider());

function provider(int $count = 2): array
{
    return [
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
        'Email must be unique' => [
            'email', fn () => validFields(['email' => User::factory()->create()->email]), $count,
        ],
    ];
}

function passwordProvider(): array
{
    return [
        'Password is required' => [
            'password', fn () => passwordFields(['password' => null]),
        ],
        'Password confirmation is required' => [
            'password', fn () => passwordFields(['password_confirmation' => null]),
        ],
        'Password cant be an integer' => [
            'password', fn () => passwordFields(['password' => 12345678, 'password_confirmation' => 12345678]),
        ],
        'Password cant be less than 8 chars' => [
            'password', fn () => passwordFields(['password' => 'small', 'password_confirmation' => 'small']),
        ],
    ];
}

function validFields(array $overrides = [], bool $hasPassword = true): array
{
    $user = User::factory()->make()->only(['name', 'email']);

    if ($hasPassword) {
        $user += passwordFields();
    }

    return array_merge($user, $overrides);
}

function passwordFields(array $overrides = []): array
{
    return array_merge([
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ], $overrides);
}
