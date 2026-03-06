<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          $this->createEmoUser();
    }

     public function createEmoUser()
    {


       Employee::create([
            'emp_id'   => 1,
            'prefix_id' => 'rkknoob',
            'first_name' => 'rkknoob',
            'last_name' => 'rkknoob',
            'phone'  => 'rkknoob',
            'fingerprint_registered'    => 1,
            'status'     => 1,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813'
        ]);

          Employee::create([
            'emp_id'   => 2,
            'prefix_id' => 'rkknoob5',
            'first_name' => 'rkknoob5',
            'last_name' => 'rkknoob5',
            'phone'  => 'rkknoob5',
            'fingerprint_registered'    => 1,
            'status'     => 1,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813'
        ]);

          Employee::create([
            'emp_id'   => 3,
            'prefix_id' => 'rkknoob2',
            'first_name' => 'rkknoob2',
            'last_name' => 'rkknoob2',
            'phone'  => 'rkknoob2',
            'fingerprint_registered'    => 1,
            'status'     => 1,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813'
        ]);

             

            Employee::create([
            'emp_id'   => 4,
            'prefix_id' => 'rkknoob3',
            'first_name' => 'rkknoob3',
            'last_name' => 'rkknoob3',
            'phone'  => 'rkknoob2',
            'fingerprint_registered'    => 1,
            'status'     => 1,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813'
        ]);

                  Employee::create([
            'emp_id'   => 5,
            'prefix_id' => 'rkknoob4',
            'first_name' => 'rkknoob4',
            'last_name' => 'rkknoob4',
            'phone'  => 'rkknoob4',
            'fingerprint_registered'    => 1,
            'status'     => 1,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813'
        ]);

 

    }
}
