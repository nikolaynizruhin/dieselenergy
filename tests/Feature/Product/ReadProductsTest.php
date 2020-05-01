<?php

namespace Tests\Feature\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_products()
    {
        $this->get(route('products.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_products()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        [$petrol, $diesel] = factory(Product::class, 2)->create();

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertSuccessful()
            ->assertViewIs('products.index')
            ->assertViewHas('products')
            ->assertSee($diesel->name)
            ->assertSee($petrol->name);
    }
}
