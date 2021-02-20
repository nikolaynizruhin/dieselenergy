<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        [$sdmo, $hyundai, $bosch] = Brand::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'SDMO Brand'],
                ['name' => 'Hyundai Brand'],
                ['name' => 'Bosch'],
            ))->create();

        $this->login()
            ->get(route('admin.brands.index', ['search' => 'Brand']))
            ->assertSeeInOrder([$hyundai->name, $sdmo->name])
            ->assertDontSee($bosch->name);
    }
}
