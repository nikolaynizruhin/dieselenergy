<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Tests\TestCase;

class DeleteBrandTest extends TestCase
{
    /**
     * Brand.
     *
     * @var \App\Models\Brand
     */
    private $brand;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->brand = Brand::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_brand()
    {
        $this->delete(route('admin.brands.destroy', $this->brand))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_brand()
    {
        $this->login()
            ->from(route('admin.brands.index'))
            ->delete(route('admin.brands.destroy', $this->brand))
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.deleted'));

        $this->assertDeleted($this->brand);
    }
}
