<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Devicelog, Branches, Department, Devieslog, Organization,Prefixes};

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Http\Requests\DevicelogRequest;

class DeviceslogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request): View
    {
        $q = (string) $request->get('q', '');

        $deviceslog = Devieslog::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('serial_num', 'like', "%{$q}%")->orWhere('ip_address', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('deviceslog.index', compact('deviceslog','q'));
    }

    public function create(): View
    {
        return view('deviceslog.create');
    }

    public function store(DevicelogRequest $request): RedirectResponse
    {
        $data = $request->validated();
        

        // รองรับค่า datetime-local "YYYY-MM-DDTHH:MM"
        // if (is_string($data['created_date'])) {
        //     $data['created_date'] = Carbon::parse($data['created_date']);
        // }

        $device = Devieslog::create($data);

        return redirect()->route('deviceslog.show', $device)
            ->with('success', 'สร้างอุปกรณ์สำเร็จ');
    }

    public function show(Devieslog $deviceslog): View
    {

   
        return view('deviceslog.show', compact('deviceslog'));
    }

    public function edit(Devieslog $deviceslog): View
    {
        return view('deviceslog.edit', compact('deviceslog'));
    }

    public function update(DevicelogRequest $request, Devieslog $deviceslog): RedirectResponse
    {
        $data = $request->validated();

     

        $deviceslog->update($data);

        return redirect()->route('deviceslog.show', $deviceslog)
            ->with('success', 'บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Devieslog $deviceslog): RedirectResponse
    {
        $deviceslog->delete();

        return redirect()->route('deviceslog.index')
            ->with('success', 'ลบอุปกรณ์แล้ว');
    }
}
