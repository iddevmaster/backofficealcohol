<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Branches;
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

        $departments = Department::with('branches')
            ->when($q, function ($query) use ($q) {
                $query->where('dpm_id', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%")
                    ->orWhereHas('branches', function ($q2) use ($q) {
                        $q2->where('brn_id', 'like', "%{$q}%");
                    })
                    ->orWhereHas('branches', function ($q3) use ($q) {
                        $q3->where('name', 'like', "%{$q}%");
                    });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('departments.index', compact('departments', 'q'));
    }

    public function create(): View
    {
        $department = new Department();

        $branches = Branches::orderBy('name')->get();

        return view('departments.create', compact('department', 'branches'));
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

        $branches = Branches::orderBy('name')->get();
        return view('departments.edit', compact('department', 'branches'));
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
