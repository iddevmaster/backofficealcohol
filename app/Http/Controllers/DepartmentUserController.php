<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Branches;

class DepartmentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request): View
    {

    

$orgId = auth()->user()->org_id ?? null;
$q     = request('q');

$departments = Department::with('branches')
    ->when($orgId, fn($qq) => $qq->whereRelation('branches', 'org_id', $orgId))
    ->when($q, function ($query) use ($q) {
        $query->where(function ($w) use ($q) {
            $w->where('dpm_id', 'like', "%{$q}%")
              ->orWhere('name',   'like', "%{$q}%")
              ->orWhere('brn_id', 'like', "%{$q}%")
              ->orWhereHas('branches', function ($b) use ($q) {
                  $b->where('id',   'like', "%{$q}%")
                    ->orWhere('name','like', "%{$q}%");
              });
        });
    })
    ->orderByDesc('id')
    ->paginate(10)
    ->withQueryString();
        return view('departmentsUser.index', compact('departments', 'q'));
    }

     public function create(): View
    {
        $department = new Department();
        $orgId = auth()->user()->org_id ?? null;
        $branches = Branches::where('org_id',$orgId)->orderBy('name')->get();

        return view('departmentsUser.create', compact('department', 'branches'));
    }

    public function store(DepartmentRequest $request): RedirectResponse
    {

        Department::create($request->validated());
        return redirect()->route('departmentsUser.index')->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function show(Department $department): View
    {
        return view('departmentsUser.show', compact('department'));
    }

    public function edit(Department $department): View|RedirectResponse
    {
       
        $orgId = auth()->user()->org_id ?? null;
        $branches = Branches::where('org_id',$orgId)->orderBy('name')->get();
        $checkorg = Branches::where('id',$department->brn_id)->first();
        if($orgId != $checkorg->org_id){
           return redirect()->route('departmentsUser.index')->with('error','ไม่อนุญาต');
        }
        return view('departmentsUser.edit', compact('department', 'branches'));
    }

    public function update(DepartmentRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->validated());
        return redirect()->route('departmentsUser.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }

    

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();
        return redirect()->route('departmentsUser.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
