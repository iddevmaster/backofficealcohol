<?php

use App\Models\Employee;
use App\Models\Organization;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    
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

it('can record alcohol scan with an uploaded image file using parameter testing_image', function () {
    $file = UploadedFile::fake()->image('test_image.jpg');

    $response = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'testing_image' => $file,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
        ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    Storage::disk('public')->assertExists($record->testing_image);
});

it('can record alcohol scan with an uploaded image file using parameter image', function () {
    $file = UploadedFile::fake()->image('test_image.jpg');

    $response = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'image' => $file,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
        ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    Storage::disk('public')->assertExists($record->testing_image);
});

it('can record alcohol scan with a base64 encoded image string using parameter image', function () {
    // Base64 for 1x1 pixel black png
    $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    $response = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'image' => $base64Image,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
        ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    expect($record->testing_image)->toStartWith('test-images/');
    expect($record->testing_image)->toEndWith('.jpg');
    Storage::disk('public')->assertExists($record->testing_image);
});

it('can record alcohol scan with a raw base64 encoded image string without prefix using parameter image', function () {
    // Raw Base64 for 1x1 pixel black png (starts without data: prefix)
    $rawBase64Image = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    $response = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'image' => $rawBase64Image,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
        ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    expect($record->testing_image)->toStartWith('test-images/');
    expect($record->testing_image)->toEndWith('.jpg');
    Storage::disk('public')->assertExists($record->testing_image);
});

it('returns existing record and does not duplicate when posting same alcohol scan twice', function () {
    $scannedAt = now()->subMinutes(10)->toIso8601String();

    // 1st request
    $response1 = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => $scannedAt,
    ]);

    $response1->assertStatus(201);
    $id1 = $response1->json('id');

    // 2nd request (duplicate)
    $response2 = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => $scannedAt,
    ]);

    $response2->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
            'id' => $id1,
        ]);

    // Ensure only 1 record is in database
    expect(\App\Models\TestHistory::count())->toBe(1);
});

it('returns existing record and does not duplicate when posting same fingerprint scan twice', function () {
    $scannedAt = now()->subMinutes(5)->toIso8601String();

    // 1st request
    $response1 = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'fingerprint',
        'result' => 'match',
        'scanned_at' => $scannedAt,
    ]);

    $response1->assertStatus(201);
    $id1 = $response1->json('id');

    // 2nd request (duplicate)
    $response2 = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'fingerprint',
        'result' => 'match',
        'scanned_at' => $scannedAt,
    ]);

    $response2->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
            'id' => $id1,
        ]);

    // Ensure only 1 record is in database
    expect(\App\Models\DeviceScan::count())->toBe(1);
});
