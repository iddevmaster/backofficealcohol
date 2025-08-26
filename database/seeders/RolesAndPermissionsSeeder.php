<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $guard = 'web';
 app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $superRole = Role::create(['name' => 'super-admin', 'guard_name' => $guard]);
        $adminRole = Role::create(['name' => 'admin','guard_name' => $guard]);
        $editorRole = Role::create(['name' => 'editor', 'guard_name' => $guard]);
        $userRole = Role::create(['name' => 'user', 'guard_name' => $guard]);

        // Create permissions
        // $ViewPostPermission = Permission::create(['name' => 'list department']);
        // $createPostPermission = Permission::create(['name' => 'create department']);
        // $storePostPermission = Permission::create(['name' => 'store department']);
        // $editPostPermission = Permission::create(['name' => 'edit department']);
        // $deletePostPermission = Permission::create(['name' => 'delete department']);

        // // Assign permissions to roles
        // $superRole->givePermissionTo($ViewPostPermission);
        // $superRole->givePermissionTo($createPostPermission);
        // $superRole->givePermissionTo($storePostPermission);
        // $superRole->givePermissionTo($editPostPermission);
        // $superRole->givePermissionTo($deletePostPermission);

       
        // ตั้ง guard ถ้าใช้ web (ค่า default)
        $guard = 'web';

        // กำหนดสิทธิเป็นกลุ่มๆ (ชื่อสิทธิใช้สไตล์ที่คุณเริ่ม เช่น "list department")
        $resources = [
            'departments'   => ['list', 'create','store', 'edit', 'update', 'show', 'delete'],
            'branches'       => ['list', 'create','store', 'edit', 'update', 'show', 'delete'],
            'prefixes'       => ['list', 'create','store', 'edit', 'update', 'show', 'delete'],
            'organizations' => ['list', 'create','store', 'edit', 'update', 'show', 'delete'],
            // เพิ่มได้ตามต้องการ...
        ];



        // สร้าง permissions ทั้งหมด
        foreach ($resources as $res => $actions) {
            foreach ($actions as $act) {
                Permission::firstOrCreate(
                    ['name' => "{$act} {$res}",'guard_name' => $guard]
                );
            }
        }


        





$user = User::find(1); // สมมติ user id=1
$user->assignRole('super-admin');
$superRole->givePermissionTo(Permission::all());


$user2 = User::find(2); // สมมติ user id=1
$user2->assignRole('admin');



$user3 = User::find(3); // สมมติ user id=1
$user3->assignRole('editor');



$user4 = User::find(4); // สมมติ user id=1
$user4->assignRole('user');



 $adminRole->givePermissionTo([
            'list branches',
        ]);

        $editorRole->givePermissionTo([
            'list branches',
        ]);
   


           $userRole->givePermissionTo([
            'list departments', 'create departments'
        ]);

    
    }
}
