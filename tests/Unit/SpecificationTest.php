<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Specification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_attribute()
    {
        $specification = Specification::factory()
            ->for(Attribute::factory())
            ->create();

        $this->assertInstanceOf(Attribute::class, $specification->attribute);
    }
}
