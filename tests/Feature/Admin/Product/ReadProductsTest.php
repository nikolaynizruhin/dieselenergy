<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_products()
    {
        $this->get(route('admin.products.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_products()
    {
        $user = User::factory()->create();

        [$petrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Petrol'],
                ['name' => 'Diesel'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.products.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $petrol->name]);
    }
}
