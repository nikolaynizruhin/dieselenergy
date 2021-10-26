<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Str;

trait HasValidation
{
    public function provider($count = 1): array
    {
        return [
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
            'Email must be unique' => [
                'email', fn () => $this->validFields(['email' => User::factory()->create()->email]), $count,
            ],
            'Password is required' => [
                'password', fn () => $this->validFields(['password' => null]),
            ],
            'Password confirmation is required' => [
                'password', fn () => $this->validFields(['password_confirmation' => null]),
            ],
            'Password cant be an integer' => [
                'password', fn () => $this->validFields(['password' => 12345678, 'password_confirmation' => 12345678]),
            ],
            'Password cant be less than 8 chars' => [
                'password', fn () => $this->validFields(['password' => 'small', 'password_confirmation' => 'small']),
            ],
        ];
    }
}
