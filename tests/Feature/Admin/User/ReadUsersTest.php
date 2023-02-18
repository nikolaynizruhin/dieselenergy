<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadUsersTest extends TestCase
{
    /** @test */
    public function guest_cant_read_users(): void
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_users(): void
    {
        [$john, $jane] = User::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'John Doe'],
                ['name' => 'Jane Doe'],
            ))->create();

        $this->login()
            ->get(route('admin.users.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSeeInOrder([$jane->name, $john->name]);
    }
}
