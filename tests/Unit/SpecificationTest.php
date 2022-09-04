<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Specification;
use Tests\TestCase;

class SpecificationTest extends TestCase
{
    /** @test */
    public function it_has_attribute()
    {
        $specification = Specification::factory()
            ->forAttribute()
            ->create();

        $this->assertInstanceOf(Attribute::class, $specification->attribute);
    }

    /** @test */
    public function it_can_toggle_feature()
    {
        $specification = Specification::factory()
            ->regular()
            ->forAttribute()
            ->create();

        $specification->toggle();

        $this->assertTrue($specification->is_featured);
    }
}
