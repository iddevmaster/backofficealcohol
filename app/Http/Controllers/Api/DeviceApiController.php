<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreScanRequest;
use App\Http\Requests\Api\StoreTestRequest;
use App\Models\DeviceScan;
use App\Models\Device;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\OrgDevice;
use App\Models\TestHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeviceApiController extends Controller
{
    /**
     * POST /api/device/register
     *
     * Register device hardware identifiers and return master configuration data.
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'serial_num' => 'required|string',
            'ip_address' => 'required|string',
            'mac_address' => 'required|string',
        ]);

        $device = Device::where('serial_num', $request->serial_num)->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        // Update the device
        $device->ip_address = $request->ip_address;
        $device->pi_mac_address = $request->mac_address;
        $device->save();

        // Get organization info
        $orgDevice = OrgDevice::where('serial_num', $request->serial_num)->first();

        if (!$orgDevice) {
            return response()->json([
                'success' => false,
                'message' => 'Device not assigned to any organization'
            ], 404);
        }

        $org = $orgDevice->organization;

        if (!$org) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'org_id' => $org->org_id,
                'org_code' => $org->org_code,
                'device_id' => $device->serial_num,
                'status' => 'active'
            ]
        ]);
    }

    /**
     * POST /api/device/heartbeat
     *
     * Receive heartbeat from device.
     */
    public function heartbeat(Request $request): JsonResponse
    {
        $request->validate([
            'device_id' => 'required|string',
            'status' => 'required|string',
        ]);

        $device = Device::where('serial_num', $request->device_id)->first();

        if ($device) {
            // Update lastseen_at to keep track of last heartbeat
            $device->lastseen_at = now();
            $device->save();

            return response()->json([
                'success' => true,
                'message' => 'Heartbeat received'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }
    }
    /**
     * GET /api/device/employee/{org_id}/{emp_id}
     *
     * Return employee profile and fingerprints by concatenating org_code and emp_id.
     */
    public function getEmployee(string $orgId, string $empId): JsonResponse
    {
        $org = Organization::where('org_id', $orgId)->first();

        if (!$org) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        $searchEmpId = $org->org_code . "E" . $empId;

        $employee = Employee::with(['prefix', 'fingerprints'])
            ->where('emp_id', $searchEmpId)
            ->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $employee->id,
                'emp_id' => $employee->emp_id,
                'full_name' => $employee->full_name,
                'status' => $employee->status,
                'org_id' => $employee->org_id,
                'fingerprints' => $employee->fingerprints->map(fn($fp) => [
                    'id' => $fp->id,
                    'finger_no' => $fp->finger_no,
                    'fingerprint_code' => $fp->fingerprint_code,
                ]),
            ],
        ]);
    }

    /**
     * POST /api/device/test
     *
     * Store a new alcohol test record (legacy endpoint).
     */
    public function storeTest(StoreTestRequest $request): JsonResponse
    {
        $employee = Employee::where('emp_id', $request->emp_id)->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found',
            ], 404);
        }

        $imagePath = $request->file('testing_image')
            ? $request->file('testing_image')->store('test-images', 'public')
            : null;

        $testHistory = TestHistory::create([
            'tester_id' => $employee->id,
            'device_sn' => $request->device_sn,
            'alcohol_level' => $request->alcohol_level,
            'testing_image' => $imagePath,
            'testing_date' => \Carbon\Carbon::parse($request->testing_date, 'UTC')->setTimezone('Asia/Bangkok')->toDateTimeString(),
            'org_id' => $request->org_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Test data stored successfully',
        ], 201);
    }

    /**
     * GET /api/device/employees/{org_id}
     *
     * Bulk sync employees for an organization.
     */
    public function getEmployees(string $orgId, Request $request): JsonResponse
    {
        $org = Organization::where('org_id', $orgId)->first();

        if (!$org) {
            return response()->json(['success' => false, 'message' => 'Organization not found'], 404);
        }

        $query = Employee::with('fingerprints')->where('org_id', $org->id);

        if ($request->has('updated_since')) {
            $updatedSince = \Carbon\Carbon::parse($request->updated_since, 'UTC')->setTimezone('Asia/Bangkok')->toDateTimeString();
            $query->where('updated_at', '>', $updatedSince);
        }

        $employees = $query->get()->map(fn($emp) => [
            'id' => $emp->id,
            'emp_id' => $emp->emp_id,
            'full_name' => $emp->full_name,
            'org_id' => $org->org_id,
            'updated_at' => $emp->updated_at->toIso8601String(),
            'fingerprints' => $emp->fingerprints->map(fn($fp) => [
                'id' => $fp->id,
                'finger_index' => $fp->finger_no,
                'fingerprint_code' => $fp->fingerprint_code,
                'updated_at' => $fp->updated_at->toIso8601String(),
            ]),
        ]);

        return response()->json($employees);
    }

    /**
     * POST /api/device/scans/{org_id}
     *
     * Unified endpoint for alcohol, fingerprint, and identification scans.
     */
    public function storeScan(StoreScanRequest $request, string $orgId): JsonResponse
    {
        $org = Organization::where('org_id', $orgId)->first();
        if (!$org) {
            return response()->json(['success' => false, 'message' => 'Organization not found'], 404);
        }

        $employee = Employee::where('id', $request->employee_id)
            ->where('org_id', $org->id)
            ->first();

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }

        $scannedAt = \Carbon\Carbon::parse($request->scanned_at, 'UTC')->setTimezone('Asia/Bangkok')->toDateTimeString();

        if ($request->scan_type === 'alcohol') {
            $imagePath = null;
            if ($request->file('testing_image')) {
                $imagePath = $request->file('testing_image')->store('test-images', 'public');
            } elseif ($request->filled('testing_image')) {
                $data = $request->input('testing_image');
                // Remove data:image/...;base64, prefix if present
                if (preg_match('/^data:image\/(\w+);base64,/', $data, $matches)) {
                    $data = substr($data, strpos($data, ',') + 1);
                }
                $decodedImage = base64_decode($data);
                if ($decodedImage) {
                    $fileName = 'test-images/' . uniqid() . '.jpg';
                    \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $decodedImage);
                    $imagePath = $fileName;
                }
            }

            $record = TestHistory::create([
                'tester_id' => $employee->id,
                'device_sn' => $request->device_id,
                'alcohol_level' => $request->value ?? 0,
                'result' => $request->result,
                'testing_image' => $imagePath,
                'testing_date' => $scannedAt,
                'org_id' => $org->id,
            ]);
        } else {
            $record = DeviceScan::create([
                'employee_id' => $employee->id,
                'org_id' => $org->id,
                'device_id' => $request->device_id,
                'scan_type' => $request->scan_type,
                'result' => $request->result,
                'scanned_at' => $scannedAt,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Scan result recorded',
            'testing_image' => $imagePath,
            'id' => $record->id,
        ], 201);
    }
}
