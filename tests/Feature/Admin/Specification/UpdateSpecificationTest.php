<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Specification;
use Tests\TestCase;

class UpdateSpecificationTest extends TestCase
{
    /**
     * Specification.
     */
    private Specification $specification;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->specification = Specification::factory()->regular()->create();
    }

    /** @test */
    public function guest_cant_update_specification_feature(): void
    {
        $this->put(route('admin.specifications.feature.update', $this->specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_specification_feature(): void
    {
        $this->login()
            ->put(route('admin.specifications.feature.update', $this->specification))
            ->assertRedirect(route('admin.categories.show', $this->specification->category_id))
            ->assertSessionHas('status', trans('specification.updated'));

        $this->assertTrue($this->specification->fresh()->is_featured);
    }
}
