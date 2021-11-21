<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Specification;
use Tests\TestCase;

class DeleteSpecificationTest extends TestCase
{
    /**
     * Specification.
     *
     * @var \App\Models\Specification
     */
    private $specification;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->specification = Specification::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_specification()
    {
        $this->delete(route('admin.specifications.destroy', $this->specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_specification()
    {
        $this->login()
            ->from(route('admin.categories.show', $this->specification->category_id))
            ->delete(route('admin.specifications.destroy', $this->specification))
            ->assertRedirect(route('admin.categories.show', $this->specification->category_id))
            ->assertSessionHas('status', trans('specification.deleted'));

        $this->assertDeleted($this->specification);
    }
}
