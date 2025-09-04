<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Employee, Branches, Department, Organization};

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Requests\EmployeeRequest;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request): View
    {
        $q     = $request->get('q');
        $orgId = $request->get('org_id');

        $employees = Employee::query()
            ->with(['organization','branches','department'])
            ->when($orgId, fn($qq) => $qq->where('org_id', $orgId))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('emp_id','like',"%{$q}%")
                      ->orWhere('first_name','like',"%{$q}%")
                      ->orWhere('last_name','like',"%{$q}%")
                      ->orWhere('phone','like',"%{$q}%")
                      ->orWhereHas('branches', fn($b)=>$b->where('name','like',"%{$q}%"))
                      ->orWhereHas('department', fn($d)=>$d->where('name','like',"%{$q}%"));
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $organizations = Organization::orderBy('name')->get(['id','name']);

        return view('employees.index', compact('employees','organizations','q','orgId'));
    }

    public function create(): View
    {
        $organizations = Organization::orderBy('name')->get(['id','name']);
        $branches      = Branches::orderBy('name')->get(['id','name','org_id']);
        $departments   = Department::orderBy('name')->get(['id','name','brn_id']);

        return view('employees.create', compact('organizations','branches','departments'));
    }

    public function store(EmployeeRequest $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        // upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('employees','public');
        }

        $emp = Employee::create($data);

        return redirect()->route('employees.show', $emp)->with('success','สร้างพนักงานสำเร็จ');
    }

    public function show(Employee $employee): View
    {
        $employee->load(['organization','branches','department']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $organizations = Organization::orderBy('name')->get(['id','name']);
        $branches      = Branches::orderBy('name')->get(['id','name','org_id']);
        $departments   = Department::orderBy('name')->get(['id','name','brn_id']);

        return view('employees.edit', compact('employee','organizations','branches','departments'));
    }

    public function update(EmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            // ลบไฟล์เก่า (ถ้ามี)
            if ($employee->image) {
                Storage::disk('public')->delete($employee->image);
            }
            $data['image'] = $request->file('image')->store('employees','public');
        }

        $employee->update($data);


        return redirect()->route('employees.show', $employee)->with('success','บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        // ถ้าต้องการลบไฟล์จริง ๆ ตอนลบ (แม้ soft delete) ให้เปิดใช้ 2 บรรทัดนี้:
        // if ($employee->image) Storage::disk('public')->delete($employee->image);

        $employee->delete();
        return redirect()->route('employees.index')->with('success','ลบพนักงานแล้ว');
    }

    private function validatedData(EmployeeRequest $request): array
    {
        $data = $request->validated();

        // จัดการ boolean จาก checkbox
        $data['fingerprint_registered'] = $request->boolean('fingerprint_registered');
        $data['status']                 = $request->boolean('status');

        return $data;
    }
}
