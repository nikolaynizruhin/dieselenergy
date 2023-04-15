<?php


use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    [$this->adam, $this->tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['id' => 788365],
            ['id' => 987445],
        ))->create();
});

test('guest cant sort orders', function () {
    $this->get(route('admin.dashboard', ['sort' => 'id']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort orders ascending', function () {
    $this->login()
        ->get(route('admin.dashboard', ['sort' => 'id']))
        ->assertSuccessful()
        ->assertViewIs('admin.dashboard')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$this->adam->id, $this->tom->id]);
});

test('admin can sort orders descending', function () {
    $this->login()
        ->get(route('admin.dashboard', ['sort' => '-id']))
        ->assertSuccessful()
        ->assertViewIs('admin.dashboard')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$this->tom->id, $this->adam->id]);
});
