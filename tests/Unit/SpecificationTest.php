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
        $attribute = Attribute::factory()->create();
        $specification = Specification::factory()->create(['attribute_id' => $attribute->id]);

        $this->assertInstanceOf(Attribute::class, $specification->attribute);
        $this->assertTrue($specification->attribute->is($attribute));
    }
}
