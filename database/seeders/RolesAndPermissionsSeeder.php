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
        $superRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => $guard]);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guard]);
        $officerRole = Role::firstOrCreate(['name' => 'officer', 'guard_name' => $guard]);
        $employeeRole = Role::firstOrCreate(['name' => 'employee', 'guard_name' => $guard]);

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
            'departments' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'branches' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'prefixes' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'organizations' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'users' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'roles' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'permissions' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'devices' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'org_devices' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'deviceslog' => ['list'],
            'employees' => ['list', 'create', 'store', 'edit', 'update', 'show', 'delete'],
            'reports' => ['access'],
            'histories' => ['list'],
            'finger' => ['list'],
            'anonymous-tests' => ['list'],
        ];



        // สร้าง permissions ทั้งหมด
        foreach ($resources as $res => $actions) {
            foreach ($actions as $act) {
                Permission::firstOrCreate(
                    ['name' => "{$act} {$res}", 'guard_name' => $guard]
                );
            }
        }








        $user = User::find(1); // สมมติ user id=1
        $user->assignRole('super-admin');


        $user2 = User::find(2); // สมมติ user id=2
        $user2->assignRole('admin');



        $superRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo(Permission::whereNot('name', "LIKE", "%devices%")->whereNot('name', "LIKE", "%deviceslog%")->get());

        $officerRole->givePermissionTo(
            Permission::where("name", "LIKE", "%reports%")
                ->where("name", "LIKE", "%histories%")
                ->where("name", "LIKE", "%finger%")
                ->get()
        );
    }
}
