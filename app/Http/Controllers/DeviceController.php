<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\DeviceRequest;
use Carbon\Carbon;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request): View
    {
        $q = (string) $request->get('q', '');

        $devices = Device::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('model', 'like', "%{$q}%")
                      ->orWhere('serial_num', 'like', "%{$q}%")
                      ->orWhere('ip_address', 'like', "%{$q}%")
                      ->orWhere('sensor_sn', 'like', "%{$q}%")
                      ->orWhere('sensor_body_sn', 'like', "%{$q}%")
                      ->orWhere('pi_mac_address', 'like', "%{$q}%")
                      ->orWhere('status', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('devices.index', compact('devices','q'));
    }

    public function create(): View
    {
        return view('devices.create');
    }

    public function store(DeviceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // รองรับค่า datetime-local "YYYY-MM-DDTHH:MM"
        if (is_string($data['created_date'])) {
            $data['created_date'] = Carbon::parse($data['created_date']);
        }

        $device = Device::create($data);

        return redirect()->route('devices.show', $device)
            ->with('success', 'สร้างอุปกรณ์สำเร็จ');
    }

    public function show(Device $device): View
    {
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device): View
    {
        return view('devices.edit', compact('device'));
    }

    public function update(DeviceRequest $request, Device $device): RedirectResponse
    {
        $data = $request->validated();

        if (is_string($data['created_date'])) {
            $data['created_date'] = Carbon::parse($data['created_date']);
        }

        $device->update($data);

        return redirect()->route('devices.show', $device)
            ->with('success', 'บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Device $device): RedirectResponse
    {
        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'ลบอุปกรณ์แล้ว');
    }
}
