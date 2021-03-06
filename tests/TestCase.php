<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Login user.
     *
     * @param  \App\Models\User|null  $user
     * @return $this
     */
    protected function login($user = null)
    {
        $user = $user ?: User::factory()->create();

        $this->actingAs($user);

        return $this;
    }
}
