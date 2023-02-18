<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Tests\TestCase;

class DeleteAttributeTest extends TestCase
{
    /**
     * Attribute.
     */
    private Attribute $attribute;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->attribute = Attribute::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_attribute(): void
    {
        $this->delete(route('admin.attributes.destroy', $this->attribute))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_attribute(): void
    {
        $this->login()
            ->from(route('admin.attributes.index'))
            ->delete(route('admin.attributes.destroy', $this->attribute))
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.deleted'));

        $this->assertModelMissing($this->attribute);
    }
}
