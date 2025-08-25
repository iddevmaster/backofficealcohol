<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prefixes;

class PrefixesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $values = ['Mr.','Mrs.','Ms.','Dr.','Prof.','คุณ','นาย','นาง','น.ส.'];

foreach ($values as $v) {
   Prefixes::firstOrCreate(['name' => $v]);
}
    }
}
