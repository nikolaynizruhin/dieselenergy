<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\User
     */
    private $user;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_user_page()
    {
        $this->get(route('admin.users.edit', $this->user))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_user_page()
    {
        $this->actingAs($this->user)
            ->get(route('admin.users.edit', $this->user))
            ->assertViewIs('admin.users.edit')
            ->assertViewHas('user', $this->user);
    }

    /** @test */
    public function guest_cant_update_user()
    {
        $this->put(route('admin.users.update', $this->user), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_user()
    {
        $this->actingAs($this->user)
            ->put(route('admin.users.update', $this->user), $fields = $this->validFields())
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', trans('user.updated'));

        $this->assertDatabaseHas('users', [
            'name' => $fields['name'],
            'email' => $fields['email'],
        ]);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_user_with_invalid_data($field, $data, $count = 1)
    {
        $this->actingAs($this->user)
            ->from(route('admin.users.edit', $this->user))
            ->put(route('admin.users.update', $this->user), $data())
            ->assertRedirect(route('admin.users.edit', $this->user))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('users', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Email is required' => [
                'email', fn () => $this->validFields(['email' => null]),
            ],
            'Email cant be an integer' => [
                'email', fn () => $this->validFields(['email' => 1]),
            ],
            'Email cant be more than 255 chars' => [
                'email', fn () => $this->validFields(['email' => Str::random(256)]),
            ],
            'Email must be valid' => [
                'email', fn () => $this->validFields(['email' => 'invalid']),
            ],
            'Email must be unique' => [
                'email', fn () => $this->validFields(['email' => User::factory()->create()->email]), 2,
            ],
        ];
    }

    /**
     * Get valid user fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        $user = User::factory()->make();

        return array_merge([
            'name' => $user->name,
            'email' => $user->email,
        ], $overrides);
    }
}
