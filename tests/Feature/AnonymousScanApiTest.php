<?php

use App\Models\Organization;
use App\Models\AnonymousTest;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    
    $this->org = Organization::create([
        'org_id' => (string) \Illuminate\Support\Str::uuid(),
        'org_code' => 'TESTORG',
        'name' => 'Test Org',
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
});

it('requires authentication to store anonymous scan', function () {
    $response = $this->postJson("/api/device/scans/anonymous/{$this->org->org_id}", [
        'device_id' => 'DEV123',
        'user_id' => '1234567890',
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 15.4,
        'scanned_at' => '2026-05-20T08:15:30.000Z',
    ]);

    $response->assertStatus(401);
});

it('can store anonymous alcohol test scan successfully without image', function () {
    \Laravel\Sanctum\Sanctum::actingAs($this->user);

    $scannedAt = '2026-05-20T08:15:30.000Z';
    $userId = '1234567890';

    $response = $this->postJson("/api/device/scans/anonymous/{$this->org->org_id}", [
        'device_id' => 'device-uuid-12345',
        'user_id' => $userId,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 15.4,
        'scanned_at' => $scannedAt,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Anonymous scan record stored successfully',
            'data' => [
                'org_id' => $this->org->org_id,
                'device_id' => 'device-uuid-12345',
                'user_id' => $userId,
                'scan_type' => 'alcohol',
                'result' => 'pass',
                'value' => 15.4,
                'scanned_at' => $scannedAt,
                'image_url' => null,
            ]
        ]);

    $this->assertDatabaseHas('anonymous_tests', [
        'device_id' => 'device-uuid-12345',
        'user_id' => $userId,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 15.4,
    ]);
});

it('can store anonymous alcohol test scan successfully with a base64 encoded image string', function () {
    \Laravel\Sanctum\Sanctum::actingAs($this->user);

    $userId = '0987654321';
    // 1x1 black pixel png base64
    $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    $response = $this->postJson("/api/device/scans/anonymous/{$this->org->org_id}", [
        'device_id' => 'device-uuid-12345',
        'user_id' => $userId,
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 15.4,
        'scanned_at' => '2026-05-20T08:15:30.000Z',
        'image' => $base64Image,
    ]);

    $response->assertStatus(201);
    
    $record = AnonymousTest::first();
    expect($record->image_path)->not->toBeNull();
    expect($record->image_path)->toStartWith('scans/anonymous/');
    Storage::disk('public')->assertExists($record->image_path);

    $response->assertJson([
        'success' => true,
        'data' => [
            'user_id' => $userId,
            'image_url' => Storage::disk('public')->url($record->image_path),
        ]
    ]);
});

it('prevents duplicate scans and returns 200 OK with the existing record', function () {
    \Laravel\Sanctum\Sanctum::actingAs($this->user);

    $payload = [
        'device_id' => 'device-uuid-12345',
        'user_id' => '1122334455',
        'scan_type' => 'alcohol',
        'result' => 'pass',
        'value' => 15.4,
        'scanned_at' => '2026-05-20T08:15:30.000Z',
    ];

    // 1st request
    $response1 = $this->postJson("/api/device/scans/anonymous/{$this->org->org_id}", $payload);
    $response1->assertStatus(201);
    $id1 = $response1->json('data.id');

    // 2nd request (duplicate)
    $response2 = $this->postJson("/api/device/scans/anonymous/{$this->org->org_id}", $payload);
    $response2->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Anonymous scan record stored successfully',
            'data' => [
                'id' => $id1,
                'user_id' => '1122334455',
            ]
        ]);

    expect(AnonymousTest::count())->toBe(1);
});

it('returns 422 validation error when inputs are invalid', function () {
    \Laravel\Sanctum\Sanctum::actingAs($this->user);

    // Invalid result, invalid value, invalid scan_type, missing device_id, missing user_id
    $response = $this->postJson("/api/device/scans/anonymous/{$this->org->org_id}", [
        'scan_type' => 'fingerprint',
        'result' => 'invalid_result',
        'value' => 700.0, // max is 600.0
        'scanned_at' => 'invalid-date',
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'Validation failed',
        ])
        ->assertJsonValidationErrors(['device_id', 'user_id', 'scan_type', 'result', 'value', 'scanned_at']);
});
