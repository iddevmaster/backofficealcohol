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


    //  Employee::create([
    //       'emp_id'   => 1,
    //       'prefix_id' => 'rkknoob',
    //       'first_name' => 'rkknoob',
    //       'last_name' => 'rkknoob',
    //       'phone'  => 'rkknoob',
    //       'fingerprint_registered'    => 1,
    //       'status'     => 1,
    //       'dpm_id'     => 1,
    //       'brn_id'     => 1,
    //       'org_id'     => 1,
    //       'phone'      => '0833268813'
    //   ]);
  }
}
