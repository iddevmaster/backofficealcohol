<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


     $this->call(UserSeeder::class);
      $this->call([
        RolesAndPermissionsSeeder::class,
        
        
        // RoleSeeder::class,
        // CreateAdminUserSeeder::class,
    ]);
      $this->call(\Database\Seeders\OrganizeSeeder::class);
      $this->call(\Database\Seeders\DepartmentSeeder::class);
    $this->call(\Database\Seeders\BranchesSeeder::class);
    //   $this->call(\Database\Seeders\ProvinceSeeder::class);
    //   $this->call(\Database\Seeders\TambonSeeder::class);
    //   $this->call(\Database\Seeders\AmphursSeeder::class);
         $this->call(\Database\Seeders\PrefixesSeeder::class);
    }
}
