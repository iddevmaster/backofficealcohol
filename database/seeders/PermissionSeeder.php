<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $permissions = [
'department-list', 'department-create', 'department-edit', 'department-delete',
'product-list', 'product-create', 'product-edit', 'product-delete'
];

foreach ($permissions as $permission) {
Permission::create(['name' => $permission,'guard_name' => 'web']);
}
        //
        //   $actions = [
        //     'viewAny',
        //     'view',
        //     'create',
        //     'update',
        //     'delete',
        //     'restore',
        //     'forceDelete',
        // ];
 
        // $resources = [
        //     'user',
        //     'restaurant',
        // ];
 
        // collect($resources)
        //     ->crossJoin($actions)
        //     ->map(function ($set) {
        //         return implode('.', $set);
        //     })->each(function ($permission) {
        //         Permission::create(['name' => $permission]);
        //     });
    }
}
