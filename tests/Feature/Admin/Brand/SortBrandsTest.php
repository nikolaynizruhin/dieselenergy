<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortBrandsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Euro currency.
     *
     * @var \App\Models\Brand
     */
    private $hyundai;

    /**
     * Dollar currency.
     *
     * @var \App\Models\Brand
     */
    private $sdmo;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->hyundai, $this->sdmo] = Brand::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Hyundai'],
                ['name' => 'SDMO'],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_brands()
    {
        $this->get(route('admin.brands.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_brands_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.brands.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands')
            ->assertSeeInOrder([$this->hyundai->name, $this->sdmo->name]);
    }

    /** @test */
    public function admin_can_sort_brands_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.brands.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands')
            ->assertSeeInOrder([$this->sdmo->name, $this->hyundai->name]);
    }
}
