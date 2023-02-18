<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Str;

trait HasValidation
{
    public static function provider(int $count = 1): array
    {
        return [
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
            'Email must be unique' => [
                'email', fn () => self::validFields(['email' => User::factory()->create()->email]), $count,
            ],
            'Password is required' => [
                'password', fn () => self::validFields(['password' => null]),
            ],
            'Password confirmation is required' => [
                'password', fn () => self::validFields(['password_confirmation' => null]),
            ],
            'Password cant be an integer' => [
                'password', fn () => self::validFields(['password' => 12345678, 'password_confirmation' => 12345678]),
            ],
            'Password cant be less than 8 chars' => [
                'password', fn () => self::validFields(['password' => 'small', 'password_confirmation' => 'small']),
            ],
        ];
    }
}
