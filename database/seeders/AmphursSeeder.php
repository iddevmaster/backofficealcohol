<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amphurs;
use Illuminate\Support\Facades\DB;

class AmphursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
   DB::table('amphurs')->truncate();
        $json = file_get_contents(database_path('seeders/data/amphoe.json'));
        $branches = json_decode($json, true);

        foreach ($branches as $branch) {
            Amphurs::create($branch);
        }
    }
}
