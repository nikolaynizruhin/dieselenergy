<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadBrandsTest extends TestCase
{


    /** @test */
    public function guest_cant_read_brands()
    {
        $this->get(route('admin.brands.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_brands()
    {
        [$sdmo, $hyundai] = Brand::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'SDMO'],
                ['name' => 'Hyundai']
            ))->create();

        $this->login()
            ->get(route('admin.brands.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands')
            ->assertSeeInOrder([$hyundai->name, $sdmo->name]);
    }
}
