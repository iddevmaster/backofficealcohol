<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;
    public function definition(): array
    {
        return [
            'username'   => $this->faker->unique()->userName,
            'password'   => 'password', // hash อัตโนมัติ
            'email'   => $this->faker->unique()->email, // hash อัตโนมัติ
            'prefix'     => 1,
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'role_id'    => 1,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => $this->faker->phoneNumber,
            'status'     => $this->faker->boolean(90), // 90% active
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
