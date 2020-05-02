<?php

namespace Tests\Feature\Brand;

use App\Brand;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteBrandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_brand()
    {
        $brand = factory(Brand::class)->create();

        $this->delete(route('brands.destroy', $brand))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_brand()
    {
        $user = factory(User::class)->create();
        $brand = factory(Brand::class)->create();

        $this->actingAs($user)
            ->from(route('brands.index'))
            ->delete(route('brands.destroy', $brand))
            ->assertRedirect(route('brands.index'))
            ->assertSessionHas('status', 'Brand was deleted successfully!');

        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }
}
