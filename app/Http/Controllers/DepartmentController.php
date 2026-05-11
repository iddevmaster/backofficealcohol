<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Branches;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DepartmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list departments', only: ['index']),
            new Middleware('permission:create departments', only: ['create', 'store']),
            new Middleware('permission:edit departments', only: ['edit', 'update']),
            new Middleware('permission:show departments', only: ['show']),
            new Middleware('permission:delete departments', only: ['destroy']),
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

        $departments = Department::with('branches')
            ->when(!$isAdmin, fn($qq) => $qq->whereHas('branches', fn($bq) => $bq->where('org_id', $user->org_id)))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('dpm_id', 'like', "%{$q}%")
                        ->orWhere('name', 'like', "%{$q}%")
                        ->orWhereHas('branches', function ($q2) use ($q) {
                            $q2->where('brn_id', 'like', "%{$q}%")
                                ->orWhere('name', 'like', "%{$q}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('departments.index', compact('departments', 'q'));
    }

    public function create(): View
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $department = new Department();
        $branches = Branches::query()
            ->when(!$isAdmin, fn($q) => $q->where('org_id', $user->org_id))
            ->orderBy('name')
            ->get();

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
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $branches = Branches::query()
            ->when(!$isAdmin, fn($q) => $q->where('org_id', $user->org_id))
            ->orderBy('name')
            ->get();

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
