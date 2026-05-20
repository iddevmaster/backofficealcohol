<?php

use App\Models\Employee;
use App\Models\Organization;
use App\Models\Fingerprints;

beforeEach(function () {
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
        'fingerprint_registered' => false,
    ]);

    $this->user = \App\Models\User::create([
        'username' => 'testuser',
        'password' => 'password',
        'prefix_id' => '1',
        'first_name' => 'Test',
        'last_name' => 'User',
        'role_id' => '1',
        'status' => true,
    ]);
    
    \Laravel\Sanctum\Sanctum::actingAs($this->user);
});

it('can register a new fingerprint template successfully', function () {
    $response = $this->postJson("/api/device/employee/fingerprint", [
        'employee_id' => (string) $this->employee->id,
        'finger_index' => 0,
        'fingerprint_code' => 'BASE64_ENCODED_TEMPLATE_123',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Fingerprint registered successfully',
            'data' => [
                'employee_id' => $this->employee->id,
                'finger_index' => 0,
                'fingerprint_code' => 'BASE64_ENCODED_TEMPLATE_123',
            ]
        ]);

    $fingerprintId = $response->json('data.id');
    expect($fingerprintId)->not->toBeNull();

    // Verify record in database
    $record = Fingerprints::where('emp_id', $this->employee->id)->where('finger_no', 0)->first();
    expect($record)->not->toBeNull();
    expect($record->fingerprint_code)->toBe('BASE64_ENCODED_TEMPLATE_123');

    // Verify employee fingerprint flag is updated
    $this->employee->refresh();
    expect($this->employee->fingerprint_registered)->toBeTrue();
});

it('updates existing fingerprint template if same employee and finger index', function () {
    // Register initial fingerprint
    $response1 = $this->postJson("/api/device/employee/fingerprint", [
        'employee_id' => (string) $this->employee->id,
        'finger_index' => 1,
        'fingerprint_code' => 'OLD_TEMPLATE',
    ]);
    $response1->assertStatus(201);
    $initialId = $response1->json('data.id');

    // Register updated fingerprint for same finger
    $response2 = $this->postJson("/api/device/employee/fingerprint", [
        'employee_id' => (string) $this->employee->id,
        'finger_index' => 1,
        'fingerprint_code' => 'NEW_TEMPLATE',
    ]);

    $response2->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Fingerprint registered successfully',
            'data' => [
                'id' => $initialId,
                'employee_id' => $this->employee->id,
                'finger_index' => 1,
                'fingerprint_code' => 'NEW_TEMPLATE',
            ]
        ]);

    // Ensure only 1 record exists in database for this finger index
    expect(Fingerprints::where('emp_id', $this->employee->id)->where('finger_no', 1)->count())->toBe(1);

    $record = Fingerprints::where('emp_id', $this->employee->id)->where('finger_no', 1)->first();
    expect($record->fingerprint_code)->toBe('NEW_TEMPLATE');
});

it('fails validation when employee_id is missing or invalid', function () {
    // Missing employee_id
    $response = $this->postJson("/api/device/employee/fingerprint", [
        'finger_index' => 0,
        'fingerprint_code' => 'TEMPLATE',
    ]);
    $response->assertStatus(422)
        ->assertJsonStructure(['success', 'message', 'errors' => ['employee_id']]);

    // Invalid employee_id (does not exist)
    $response = $this->postJson("/api/device/employee/fingerprint", [
        'employee_id' => 99999,
        'finger_index' => 0,
        'fingerprint_code' => 'TEMPLATE',
    ]);
    $response->assertStatus(422)
        ->assertJsonStructure(['success', 'message', 'errors' => ['employee_id']]);
});

it('fails validation when finger_index is missing or invalid', function () {
    // Missing finger_index
    $response = $this->postJson("/api/device/employee/fingerprint", [
        'employee_id' => (string) $this->employee->id,
        'fingerprint_code' => 'TEMPLATE',
    ]);
    $response->assertStatus(422)
        ->assertJsonStructure(['success', 'message', 'errors' => ['finger_index']]);

    // Invalid finger_index (not an integer)
    $response = $this->postJson("/api/device/employee/fingerprint", [
        'employee_id' => (string) $this->employee->id,
        'finger_index' => 'not-an-integer',
        'fingerprint_code' => 'TEMPLATE',
    ]);
    $response->assertStatus(422)
        ->assertJsonStructure(['success', 'message', 'errors' => ['finger_index']]);
});

it('fails validation when fingerprint_code is missing', function () {
    $response = $this->postJson("/api/device/employee/fingerprint", [
        'employee_id' => (string) $this->employee->id,
        'finger_index' => 0,
    ]);
    $response->assertStatus(422)
        ->assertJsonStructure(['success', 'message', 'errors' => ['fingerprint_code']]);
});
