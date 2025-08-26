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
        //  User::create([
        //     'name'     => 'Admin User',
        //     'email'    => 'rkknoob@gmail.com',
        //     'password' => bcrypt('12345678'),
        // ])->roles()->sync(Role::where('name', RoleName::ADMIN->value)->first());


            User::create([
            'username'   => 'rkknoob',
            'password' => bcrypt('12345678'),
            'email'  => 'rkknoob@gmail.com',
            'prefix'     => 1,
            'first_name' => 'บุญเขต',
            'last_name'  => 'เรืองเจริญธรรม',
            'role_id'    => 1,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813',
            'status'     => true,
        ]);


        User::create([
            'username'   => 'admin',
            'password' => bcrypt('12345678'),
            'email'  => 'admin@gmail.com',
            'prefix'     => 1,
            'first_name' => 'admin',
            'last_name'  => 'admin',
            'role_id'    => 2,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813',
            'status'     => true,
        ]);


               User::create([
            'username'   => 'editor',
            'password' => bcrypt('12345678'),
            'email'  => 'editor@gmail.com',
            'prefix'     => 1,
            'first_name' => 'editor',
            'last_name'  => 'admin',
            'role_id'    => 3,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813',
            'status'     => true,
        ]);


        User::create([
            'username'   => 'user',
            'password' => bcrypt('12345678'),
            'email'  => 'user@gmail.com',
            'prefix'     => 1,
            'first_name' => 'user',
            'last_name'  => 'user',
            'role_id'    => 4,
            'dpm_id'     => 1,
            'brn_id'     => 1,
            'org_id'     => 1,
            'phone'      => '0833268813',
            'status'     => true,
        ]);



        // เพิ่ม Users ตัวอย่าง
        // User::factory()->count(10)->create(); // ถ้ามี Factory

//         User::firstOrCreate(
//     ['email' => 'rkknoob@admin.com'],
//     [
//         'name' => 'Admin User',
//         'password' => Hash::make('1234568'),
//     ]
// );
    }
}
