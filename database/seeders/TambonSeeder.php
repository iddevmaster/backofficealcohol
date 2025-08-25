<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tambon;
use Illuminate\Support\Facades\DB;

class TambonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tambon')->truncate();
        $json = file_get_contents(database_path('seeders/data/dist.json'));
        $branches = json_decode($json, true);

        foreach ($branches as $branch) {
            Tambon::create($branch);
        }

     
    }
}
