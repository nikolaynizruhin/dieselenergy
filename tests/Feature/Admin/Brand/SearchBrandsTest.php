<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_brands()
    {
        $brand = Brand::factory()->create();

        $this->get(route('admin.brands.index', ['search' => $brand->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_brands()
    {
        $user = User::factory()->create();

        $sdmo = Brand::factory()->create(['name' => 'SDMO Brand']);
        $hyundai = Brand::factory()->create(['name' => 'Hyundai Brand']);
        $bosch = Brand::factory()->create(['name' => 'Bosch']);

        $this->actingAs($user)
            ->get(route('admin.brands.index', ['search' => 'Brand']))
            ->assertSeeInOrder([$hyundai->name, $sdmo->name])
            ->assertDontSee($bosch->name);
    }
}
