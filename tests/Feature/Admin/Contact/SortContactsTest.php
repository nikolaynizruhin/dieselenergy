<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_sort_contacts()
    {
        $this->get(route('admin.contacts.index', ['sort' => 'created_at']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_contacts_ascending()
    {
        $user = User::factory()->create();

        [$adam, $tom] = Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.contacts.index', ['sort' => 'created_at']))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$tom->message, $adam->message]);
    }

    /** @test */
    public function admin_can_sort_contacts_descending()
    {
        $user = User::factory()->create();

        [$adam, $tom] = Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.contacts.index', ['sort' => '-created_at']))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$adam->message, $tom->message]);
    }
}
