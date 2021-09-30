<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchProductsTest extends TestCase
{


    /** @test */
    public function guest_cant_search_products()
    {
        $product = Product::factory()->create();

        $this->get(route('admin.products.index', ['search' => $product->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_products()
    {
        [$diesel, $patrol, $waterPump] = Product::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Diesel Generator'],
                ['name' => 'Patrol Generator'],
                ['name' => 'Water Pump'],
            ))->create();

        $this->login()
            ->get(route('admin.products.index', ['search' => 'Generator']))
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPump->name);
    }
}
