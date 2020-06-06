<?php

namespace Tests\Unit;

use App\Attribute;
use App\Specification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_attribute()
    {
        $attribute = factory(Attribute::class)->create();
        $specification = factory(Specification::class)->create(['attribute_id' => $attribute->id]);

        $this->assertInstanceOf(Attribute::class, $specification->attribute);
        $this->assertTrue($specification->attribute->is($attribute));
    }
}
