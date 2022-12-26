<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use HasValidation;

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
     *
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
        return array_filter(
            $this->provider(2),
            fn ($name) => in_array($name, [
                'Name is required',
                'Name cant be an integer',
                'Name cant be more than 255 chars',
                'Email is required',
                'Email cant be an integer',
                'Email cant be more than 255 chars',
                'Email must be valid',
                'Email must be unique',
            ]),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Get valid user fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        $user = User::factory()->make();

        return array_merge([
            'name' => $user->name,
            'email' => $user->email,
        ], $overrides);
    }
}
