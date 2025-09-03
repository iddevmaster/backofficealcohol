<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        $mac = strtoupper(implode(':', str_split($this->faker->bothify('##########'), 2)));

        return [
            'model'            => $this->faker->randomElement(['A1','B2','C3']).'-'.$this->faker->numerify('###'),
            'serial_num'       => strtoupper($this->faker->bothify('SN-########')),
            'ip_address'       => $this->faker->ipv4(),
            'sensor_sn'        => $this->faker->optional()->bothify('SSN-#######'),
            'sensor_body_sn'   => $this->faker->optional()->bothify('SBSN-#######'),
            'pi_mac_address'   => $mac,
            'created_date'     => $this->faker->dateTimeBetween('-90 days','now'),
            'latitude'         => $this->faker->optional()->latitude(-90,90),
            'longitude'        => $this->faker->optional()->longitude(-180,180),
            'tested_count'     => $this->faker->numberBetween(0, 500),
            'last_calibration' => $this->faker->dateTimeBetween('-1 year','-1 day')->format('Y-m-d'),
            'status'           => $this->faker->randomElement([0,1,2]),
        ];
    }
}
