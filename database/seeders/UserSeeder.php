<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        $this->createAdminUser();
    }
 
    public function createAdminUser()
    {
         User::create([
            'name'     => 'Admin User',
            'email'    => 'rkknoob@gmail.com',
            'password' => bcrypt('12345678'),
        ])->roles()->sync(Role::where('name', RoleName::ADMIN->value)->first());

//         User::firstOrCreate(
//     ['email' => 'rkknoob@admin.com'],
//     [
//         'name' => 'Admin User',
//         'password' => Hash::make('1234568'),
//     ]
// );
    }
}
