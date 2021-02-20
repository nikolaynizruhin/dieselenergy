<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteBrandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_brand()
    {
        $brand = Brand::factory()->create();

        $this->delete(route('admin.brands.destroy', $brand))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_brand()
    {
        $brand = Brand::factory()->create();

        $this->login()
            ->from(route('admin.brands.index'))
            ->delete(route('admin.brands.destroy', $brand))
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('status', trans('brand.deleted'));

        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }
}
