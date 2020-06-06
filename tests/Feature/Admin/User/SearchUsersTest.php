<?php

namespace Tests\Feature\Admin\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_users()
    {
        factory(User::class)->create(['name' => 'John Doe']);

        $this->get(route('admin.users.index', ['search' => 'john']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_users()
    {
        $admin = factory(User::class)->create();

        $john = factory(User::class)->create(['name' => 'John Doe']);
        $jane = factory(User::class)->create(['name' => 'Jane Doe']);
        $tom = factory(User::class)->create(['name' => 'Tom Jo']);

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['search' => 'Doe']))
            ->assertSeeInOrder([$jane->email, $john->email])
            ->assertDontSee($tom->email);
    }
}
