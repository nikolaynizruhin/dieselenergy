<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SearchUsersTest extends TestCase
{
    /** @test */
    public function guest_cant_search_users(): void
    {
        User::factory()->create(['name' => 'John Doe']);

        $this->get(route('admin.users.index', ['search' => 'john']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_users(): void
    {
        [$john, $jane, $tom] = User::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'John Doe'],
                ['name' => 'Jane Doe'],
                ['name' => 'Tom Jo'],
            ))->create();

        $this->login()
            ->get(route('admin.users.index', ['search' => 'Doe']))
            ->assertSeeInOrder([$jane->email, $john->email])
            ->assertDontSee($tom->email);
    }
}
