<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
       public function index(Request $request): View
    {
        $q = (string) $request->get('q', '');
        $departments = Department::query()
            ->when($q, fn($query) =>
                $query->where('dpm_id', 'like', "%{$q}%")
                      ->orWhere('name', 'like', "%{$q}%")
                      ->orWhere('brn_id', 'like', "%{$q}%")
            )
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('departments.index', compact('departments', 'q'));
    }

    public function create(): View
    {
        $department = new Department();
        return view('departments.create', compact('department'));
    }

    public function store(DepartmentRequest $request): RedirectResponse
    {
    
        Department::create($request->validated());
        return redirect()->route('departments.index')->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function show(Department $department): View
    {
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->validated());
        return redirect()->route('departments.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
