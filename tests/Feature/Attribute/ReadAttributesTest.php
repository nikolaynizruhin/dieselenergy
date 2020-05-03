<?php

namespace Tests\Feature\Attribute;

use App\Attribute;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadAttributesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_attributes()
    {
        $this->get(route('attributes.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_attributes()
    {
        $user = factory(User::class)->create();

        [$power, $weight] = factory(Attribute::class, 2)->create();

        $this->actingAs($user)
            ->get(route('attributes.index'))
            ->assertSuccessful()
            ->assertViewIs('attributes.index')
            ->assertViewHas('attributes')
            ->assertSee($power->name)
            ->assertSee($weight->name);
    }
}
