<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, LazilyRefreshDatabase;

    /**
     * Login user.
     *
     * @return $this
     */
    protected function login(?User $user = null): static
    {
        $user = $user ?: User::factory()->create();

        $this->actingAs($user);

        return $this;
    }
}
