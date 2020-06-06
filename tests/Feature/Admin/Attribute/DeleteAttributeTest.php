<?php

namespace Tests\Feature\Admin\Attribute;

use App\Attribute;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAttributeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $this->delete(route('admin.attributes.destroy', $attribute))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_attribute()
    {
        $user = factory(User::class)->create();
        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->from(route('admin.attributes.index'))
            ->delete(route('admin.attributes.destroy', $attribute))
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', 'Attribute was deleted successfully!');

        $this->assertDatabaseMissing('attributes', ['id' => $attribute->id]);
    }
}
