<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User Adam.
     *
     * @var \App\Models\User
     */
    private $adam;

    /**
     * User Ben.
     *
     * @var \App\Models\User
     */
    private $ben;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->adam, $this->ben] = User::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Ben'],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_users()
    {
        $this->get(route('admin.users.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_users_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.users.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSeeInOrder([$this->adam->name, $this->ben->name]);
    }

    /** @test */
    public function admin_can_sort_users_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.users.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSeeInOrder([$this->ben->name, $this->adam->name]);
    }
}
