<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
               DB::table('province')->truncate();
                $json = file_get_contents(database_path('seeders/data/province.json'));
        $branches = json_decode($json, true);

        foreach ($branches as $branch) {
            Province::create($branch);
        }
    }
}
