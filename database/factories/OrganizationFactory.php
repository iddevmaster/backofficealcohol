<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'org_id' => (string) \Illuminate\Support\Str::uuid(),
            'name'   => fake()->company(),
            'logo'   => fake()->optional()->imageUrl(200, 200, 'logo', true),
            'status' => fake()->boolean(80),
        ];
    }
}
