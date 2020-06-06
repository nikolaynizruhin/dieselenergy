<?php

namespace Tests\Feature\Admin\Brand;

use App\Brand;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_brands()
    {
        $brand = factory(Brand::class)->create();

        $this->get(route('admin.brands.index', ['search' => $brand->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_brands()
    {
        $user = factory(User::class)->create();

        $sdmo = factory(Brand::class)->create(['name' => 'SDMO Brand']);
        $hyundai = factory(Brand::class)->create(['name' => 'Hyundai Brand']);
        $bosch = factory(Brand::class)->create(['name' => 'Bosch']);

        $this->actingAs($user)
            ->get(route('admin.brands.index', ['search' => 'Brand']))
            ->assertSeeInOrder([$hyundai->name, $sdmo->name])
            ->assertDontSee($bosch->name);
    }
}
