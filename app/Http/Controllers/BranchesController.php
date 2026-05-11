<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Amphurs;
use App\Models\Organization;
use App\Models\Tambon;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BranchesController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list branches', only: ['index']),
            new Middleware('permission:create branches', only: ['create', 'store']),
            new Middleware('permission:edit branches', only: ['edit', 'update']),
            new Middleware('permission:show branches', only: ['show']),
            new Middleware('permission:delete branches', only: ['destroy']),
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
        $branches = Branches::query()
            ->with('organize', 'province', 'tambon', 'amphur')
            ->when(!$isAdmin, fn($qq) => $qq->where('org_id', $user->org_id))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('brn_id', 'like', "%{$q}%")
                        ->orWhere('name', 'like', "%{$q}%")
                        ->orWhere('address', 'like', "%{$q}%")
                        ->orWhereHas('province', fn($q2) => $q2->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('amphur', fn($q3) => $q3->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('tambon', fn($q4) => $q4->where('name', 'like', "%{$q}%"));
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('branches.index', compact('branches', 'q'));
    }

    public function create(): View
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $branch = new Branches();
        $organization = Organization::query()
            ->when(!$isAdmin, fn($q) => $q->where('id', $user->org_id))
            ->orderBy('name')
            ->get();
        $provinces = \App\Http\Controllers\LocationController::provincesForForm();
        return view('branches.create', compact('provinces', 'branch', 'organization'));
    }

    public function store(BranchRequest $request): RedirectResponse
    {
        Branches::create($request->validated());
        return redirect()->route('branches.index')->with('success','บันทึกข้อมูลสาขาสำเร็จ');
    }

    public function show(Branches $branch): View
    {
        return view('branches.show', compact('branch'));
    }

    public function edit(Branches $branch): View
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $organization = Organization::query()
            ->when(!$isAdmin, fn($q) => $q->where('id', $user->org_id))
            ->orderBy('name')
            ->get();

        $provinces = \App\Http\Controllers\LocationController::provincesForForm();
        $values = [
            'province_id' => $branch->province_id,
            'amphur_id'   => $branch->amphur_id,
            'tambon_id'   => $branch->tambon_id,
        ];

        return view('branches.edit', compact('branch', 'provinces', 'values', 'organization'));
    }

    public function update(BranchRequest $request, Branches $branch): RedirectResponse
    {
        $branch->update($request->validated());
        return redirect()->route('branches.index')->with('success','อัปเดตข้อมูลสาขาสำเร็จ');
    }

    public function destroy(Branches $branch): RedirectResponse
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success','ลบข้อมูลสาขาสำเร็จ');
    }
}
