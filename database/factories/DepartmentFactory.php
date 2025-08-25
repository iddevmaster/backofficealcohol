<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Department::class;
    public function definition(): array
    {
       return [
            'dpm_id' => strtoupper($this->faker->bothify('DPM-###')),
            'name'   => $this->faker->company(),
            'brn_id' => strtoupper($this->faker->bothify('BRN-##')),
        ];
    }
}
