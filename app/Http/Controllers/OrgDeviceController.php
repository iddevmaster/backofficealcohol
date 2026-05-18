<?php

namespace App\Http\Controllers;

use App\Models\OrgDevice;
use App\Models\Organization;
use App\Models\Branches;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrgDeviceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list org_devices', only: ['index']),
            new Middleware('permission:create org_devices', only: ['store']),
            new Middleware('permission:delete org_devices', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $q = (string) $request->get('q', '');

        $devices = OrgDevice::with(['organization', 'branch'])
            ->when(!$isAdmin, function ($qq) use ($user) {
                $qq->where('org_id', $user->org_id);
            })
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('serial_num', 'like', "%{$q}%")
                      ->orWhere('note', 'like', "%{$q}%")
                      ->orWhereHas('organization', function ($orgQuery) use ($q) {
                          $orgQuery->where('name', 'like', "%{$q}%");
                      })
                      ->orWhereHas('branch', function ($brnQuery) use ($q) {
                          $brnQuery->where('name', 'like', "%{$q}%");
                      });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Get organizations and devices for the add modal select dropdown
        $organizations = Organization::orderBy('name')->get();
        $masterDevices = Device::orderBy('serial_num')->get();

        return view('org_devices.index', compact('devices', 'organizations', 'masterDevices', 'q'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'serial_num' => 'required|string|max:255|exists:devices,serial_num|unique:org_devices,serial_num',
            'org_id' => 'required|exists:organizations,id',
            'brn_id' => 'required|exists:branches,id',
            'note' => 'nullable|string|max:255',
        ], [
            'name.required' => 'กรุณากรอกชื่ออุปกรณ์',
            'serial_num.required' => 'กรุณาเลือก Serial Number',
            'serial_num.exists' => 'ไม่พบ Serial Number นี้ในระบบ',
            'serial_num.unique' => 'Serial Number นี้ถูกใช้งานโดยองค์กรอื่นแล้ว',
            'org_id.required' => 'กรุณาเลือกองค์กร',
            'org_id.exists' => 'ไม่พบข้อมูลองค์กรนี้ในระบบ',
            'brn_id.required' => 'กรุณาเลือกสาขา',
            'brn_id.exists' => 'ไม่พบข้อมูลสาขานี้ในระบบ',
        ]);

        OrgDevice::create($data);

        return redirect()->route('org-devices.index')
            ->with('success', 'เพิ่มอุปกรณ์ขององค์กรสำเร็จแล้ว');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgDevice $orgDevice): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'serial_num' => 'required|string|max:255|exists:devices,serial_num|unique:org_devices,serial_num,' . $orgDevice->id,
            'org_id' => 'required|exists:organizations,id',
            'brn_id' => 'required|exists:branches,id',
            'note' => 'nullable|string|max:255',
        ], [
            'name.required' => 'กรุณากรอกชื่ออุปกรณ์',
            'serial_num.required' => 'กรุณาเลือก Serial Number',
            'serial_num.exists' => 'ไม่พบ Serial Number นี้ในระบบ',
            'serial_num.unique' => 'Serial Number นี้ถูกใช้งานโดยองค์กรอื่นแล้ว',
            'org_id.required' => 'กรุณาเลือกองค์กร',
            'org_id.exists' => 'ไม่พบข้อมูลองค์กรนี้ในระบบ',
            'brn_id.required' => 'กรุณาเลือกสาขา',
            'brn_id.exists' => 'ไม่พบข้อมูลสาขานี้ในระบบ',
        ]);

        $orgDevice->update($data);

        return redirect()->route('org-devices.index')
            ->with('success', 'อัปเดตข้อมูลอุปกรณ์ขององค์กรสำเร็จแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrgDevice $orgDevice): RedirectResponse
    {
        $orgDevice->delete();

        return redirect()->route('org-devices.index')
            ->with('success', 'ลบอุปกรณ์ขององค์กรสำเร็จแล้ว');
    }
}
