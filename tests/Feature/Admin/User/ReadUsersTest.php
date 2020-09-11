<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_users()
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_users()
    {
        [$admin, $john, $jane] = User::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Admin'],
                ['name' => 'John Doe'],
                ['name' => 'Jane Doe'],
            ))->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSeeInOrder([$jane->name, $john->name]);
    }
}
