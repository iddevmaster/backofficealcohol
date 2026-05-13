<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTestRequest;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\TestHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeviceApiController extends Controller
{
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
     * Store a new alcohol test record.
     * Accepts emp_id (string code), resolves tester_id (PK) internally.
     * Saves testing_image file to storage and stores the path.
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
            ->store('test-images', 'public');

        $testHistory = TestHistory::create([
            'tester_id' => $employee->id,
            'device_sn' => $request->device_sn,
            'alcohol_level' => $request->alcohol_level,
            'testing_image' => $imagePath,
            'testing_date' => $request->testing_date,
            'org_id' => $request->org_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Test data stored successfully',
            'data' => [
                'id' => $testHistory->id,
                'tester_id' => $testHistory->tester_id,
                'device_sn' => $testHistory->device_sn,
                'alcohol_level' => $testHistory->alcohol_level,
                'testing_image' => $testHistory->testing_image,
                'testing_date' => $testHistory->testing_date,
                'org_id' => $testHistory->org_id,
            ],
        ], 201);
    }
}
