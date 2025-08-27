<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branches>
 */
class BranchesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      return [
            'brn_id'      => strtoupper(fake()->bothify('BRN-###')),
            'name'        => fake()->company(),
            'address'     => fake()->address(),
            'tambon_id'   => fake()->numberBetween(1000,9999),
            'amphur_id'   => fake()->numberBetween(100,999),
            'province_id' => fake()->numberBetween(1,77),
            'org_id'      => 1,
        ];
    }
}
