<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadAttributesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_attributes()
    {
        $this->get(route('admin.attributes.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_attributes()
    {
        $user = User::factory()->create();

        $weight = Attribute::factory()->create(['name' => 'Weight']);
        $power = Attribute::factory()->create(['name' => 'Power']);

        $this->actingAs($user)
            ->get(route('admin.attributes.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$power->name, $weight->name]);
    }
}
