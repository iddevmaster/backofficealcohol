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

it('can record alcohol scan with an uploaded image file', function () {
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

    $this->assertDatabaseHas('test_histories', [
        'tester_id' => $this->employee->id,
        'device_sn' => 'DEV123',
        'alcohol_level' => 0.05,
        'result' => 'pass',
        'org_id' => $this->org->id,
    ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    Storage::disk('public')->assertExists($record->testing_image);
});

it('can record alcohol scan with a base64 encoded image string', function () {
    // Base64 for 1x1 pixel black png
    $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    $response = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'testing_image' => $base64Image,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
        ]);

    $this->assertDatabaseHas('test_histories', [
        'tester_id' => $this->employee->id,
        'device_sn' => 'DEV123',
        'alcohol_level' => 0.05,
        'result' => 'pass',
        'org_id' => $this->org->id,
    ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    expect($record->testing_image)->toStartWith('test-images/');
    expect($record->testing_image)->toEndWith('.png');
    Storage::disk('public')->assertExists($record->testing_image);
});

it('can record alcohol scan with a raw base64 encoded image string without prefix', function () {
    // Raw Base64 for 1x1 pixel black png (starts without data: prefix)
    $rawBase64Image = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    $response = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'testing_image' => $rawBase64Image,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
        ]);

    $this->assertDatabaseHas('test_histories', [
        'tester_id' => $this->employee->id,
        'device_sn' => 'DEV123',
        'alcohol_level' => 0.05,
        'result' => 'pass',
        'org_id' => $this->org->id,
    ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    expect($record->testing_image)->toStartWith('test-images/');
    expect($record->testing_image)->toEndWith('.png');
    Storage::disk('public')->assertExists($record->testing_image);
});

it('can record alcohol scan with a raw base64 encoded image string wrapped in literal double quotes', function () {
    // Raw Base64 wrapped in literal double quotes
    $wrappedBase64Image = '"iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="';

    $response = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'testing_image' => $wrappedBase64Image,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
        ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    expect($record->testing_image)->toStartWith('test-images/');
    expect($record->testing_image)->toEndWith('.png');
    Storage::disk('public')->assertExists($record->testing_image);
});

it('can parse raw JSON request bodies even when Content-Type header is completely missing', function () {
    $rawBase64Image = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    $payload = [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'testing_image' => $rawBase64Image,
    ];

    // Send post request using raw content with an empty Content-Type to simulate missing header
    $response = $this->call(
        'POST',
        "/api/device/scans/{$this->org->org_id}",
        [], // parameters
        [], // cookies
        [], // files
        ['CONTENT_TYPE' => ''], // server headers
        json_encode($payload) // content
    );

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Scan result recorded',
        ]);

    $record = \App\Models\TestHistory::first();
    expect($record->testing_image)->not->toBeNull();
    Storage::disk('public')->assertExists($record->testing_image);
});

it('rejects invalid base64 image strings', function () {
    $response = $this->postJson("/api/device/scans/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'employee_id' => (string) $this->employee->id,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 0.05,
        'scanned_at' => now()->toIso8601String(),
        'testing_image' => 'not-a-valid-base64-string!!!',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['testing_image']);
});
