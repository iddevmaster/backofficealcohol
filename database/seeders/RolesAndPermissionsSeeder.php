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
 app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
 $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $ViewPostPermission = Permission::create(['name' => 'list department']);
        $createPostPermission = Permission::create(['name' => 'create department']);
        $editPostPermission = Permission::create(['name' => 'edit department']);
        $deletePostPermission = Permission::create(['name' => 'delete department']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($ViewPostPermission);
        $adminRole->givePermissionTo($createPostPermission);
        $adminRole->givePermissionTo($editPostPermission);
        $adminRole->givePermissionTo($deletePostPermission);


        



        $user = User::create([
    'name' => 'Admin User',
    'email' => 'rkknoob@gmail.com',
    'password' => bcrypt('12345678'),
]);

$user->assignRole('editor'); 
    
    }
}
