<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SortUsersTest extends TestCase
{
    /** @test */
    public function guest_cant_sort_users()
    {
        $this->get(route('admin.users.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_users_by_name_ascending()
    {
        [$adam, $ben] = User::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Ben'],
            ))->create();

        $this->login()
            ->get(route('admin.users.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSeeInOrder([$adam->name, $ben->name]);
    }

    /** @test */
    public function admin_can_sort_users_by_name_descending()
    {
        [$adam, $ben] = User::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Ben'],
            ))->create();

        $this->login()
            ->get(route('admin.users.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSeeInOrder([$ben->name, $adam->name]);
    }

    /** @test */
    public function admin_can_sort_users_by_email_ascending()
    {
        [$adam, $ben] = User::factory()
            ->count(2)
            ->state(new Sequence(
                ['email' => 'adam@example.com'],
                ['email' => 'ben@example.com'],
            ))->create();

        $this->login()
            ->get(route('admin.users.index', ['sort' => 'email']))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSeeInOrder([$adam->email, $ben->email]);
    }

    /** @test */
    public function admin_can_sort_users_by_email_descending()
    {
        [$adam, $ben] = User::factory()
            ->count(2)
            ->state(new Sequence(
                ['email' => 'adam@example.com'],
                ['email' => 'ben@example.com'],
            ))->create();

        $this->login()
            ->get(route('admin.users.index', ['sort' => '-email']))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSeeInOrder([$ben->email, $adam->email]);
    }
}
