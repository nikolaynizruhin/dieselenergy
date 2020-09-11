<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchProductsTest extends TestCase
{
    use RefreshDatabase;

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
        $user = User::factory()->create();

        $diesel = Product::factory()->create(['name' => 'Diesel Generator']);
        $patrol = Product::factory()->create(['name' => 'Patrol Generator']);
        $waterPump = Product::factory()->create(['name' => 'Water Pump']);

        $this->actingAs($user)
            ->get(route('admin.products.index', ['search' => 'Generator']))
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPump->name);
    }
}
