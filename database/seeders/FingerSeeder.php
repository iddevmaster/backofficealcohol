<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fingerprints;
use App\Models\Employee;
use Illuminate\Support\Carbon;

class FingerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          $this->createFinUser();
    }

     public function createFinUser()
    {
        $mytime = Carbon::now();

       
        $getlast = Employee::latest()->first();
        

       Fingerprints::create([
            'emp_id'   => $getlast->id,
            'finger_no' => '1',
            'fingerprint_code' => 'rkknoob',
            'note' => 'rkknoob',
            'timestamp' => $mytime
        ]);

         Fingerprints::create([
            'emp_id'   => $getlast->id,
            'finger_no' => '2',
            'fingerprint_code' => 'rkknoob',
            'note' => 'rkknoob',
            'timestamp' => $mytime
        ]);
         Fingerprints::create([
            'emp_id'   => $getlast->id,
            'finger_no' => '3',
            'fingerprint_code' => 'rkknoob',
            'note' => 'rkknoob',
            'timestamp' => $mytime
        ]);
         Fingerprints::create([
            'emp_id'   => $getlast->id,
            'finger_no' => '4',
            'fingerprint_code' => 'rkknoob',
            'note' => 'rkknoob',
            'timestamp' => $mytime
        ]);
         Fingerprints::create([
           'emp_id'   => $getlast->id,
            'finger_no' => '5',
            'fingerprint_code' => 'rkknoob',
            'note' => 'rkknoob',
            'timestamp' => $mytime
        ]);
    }
}
