<?php

use App\Models\Employee;
use App\Models\Organization;
use App\Models\DeviceScan;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    // Clear and create roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    
    $this->listHistoriesPermission = Permission::firstOrCreate(['name' => 'list histories', 'guard_name' => 'web']);
    $this->adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    $this->adminRole->givePermissionTo($this->listHistoriesPermission);

    $this->org = Organization::create([
        'org_id' => (string) \Illuminate\Support\Str::uuid(),
        'org_code' => 'TESTORG',
        'name' => 'Test Org',
        'status' => true,
    ]);

    $this->employee = Employee::create([
        'emp_id' => 'TESTORG-E123',
        'emp_no' => 123,
        'prefix_id' => '1',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'org_id' => $this->org->id,
        'status' => true,
    ]);

    $this->user = User::create([
        'username' => 'adminuser',
        'password' => bcrypt('password'),
        'prefix_id' => '1',
        'first_name' => 'Test',
        'last_name' => 'Admin',
        'status' => true,
        'org_id' => $this->org->id,
        'role_id' => '1',
    ]);
    
    $this->user->assignRole($this->adminRole);
});

it('prevents guests from accessing the scan histories page', function () {
    $response = $this->get('/admin/device-scans');
    $response->assertRedirect('/login');
});

it('prevents users without list histories permission from accessing the scan histories page', function () {
    $unprivilegedUser = User::create([
        'username' => 'regularuser',
        'password' => bcrypt('password'),
        'prefix_id' => '1',
        'first_name' => 'Regular',
        'last_name' => 'User',
        'status' => true,
        'org_id' => $this->org->id,
        'role_id' => '2',
    ]);

    $response = $this->actingAs($unprivilegedUser)->get('/admin/device-scans');
    $response->assertStatus(403);
});

it('allows authorized users to access the scan histories page', function () {
    DeviceScan::create([
        'employee_id' => $this->employee->id,
        'org_id' => $this->org->id,
        'device_id' => 'DEV123',
        'scan_type' => 'fingerprint',
        'result' => 'match',
        'scanned_at' => now(),
    ]);

    $response = $this->actingAs($this->user)->get('/admin/device-scans');
    $response->assertStatus(200);
    $response->assertSee('John Doe');
    $response->assertSee('DEV123');
    $response->assertSee('พบข้อมูลตรงกัน');
});

it('filters scan histories by search query and type', function () {
    DeviceScan::create([
        'employee_id' => $this->employee->id,
        'org_id' => $this->org->id,
        'device_id' => 'DEV_FINGER',
        'scan_type' => 'fingerprint',
        'result' => 'match',
        'scanned_at' => now(),
    ]);

    DeviceScan::create([
        'employee_id' => $this->employee->id,
        'org_id' => $this->org->id,
        'device_id' => 'DEV_ID',
        'scan_type' => 'identification',
        'result' => 'identified',
        'scanned_at' => now(),
    ]);

    // Search query matching finger device
    $response = $this->actingAs($this->user)->get('/admin/device-scans?q=DEV_FINGER');
    $response->assertStatus(200);
    $response->assertSee('DEV_FINGER');
    $response->assertDontSee('DEV_ID');

    // Filter by type "identification"
    $response = $this->actingAs($this->user)->get('/admin/device-scans?scan_type=identification');
    $response->assertStatus(200);
    $response->assertSee('DEV_ID');
    $response->assertDontSee('DEV_FINGER');
});
