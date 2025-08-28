<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Role, Permission, User};
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $q = $request->get('q');
        $guard = $request->get('guard_name');

        $permissions = Permission::query()
            ->when($q, fn($qq)=>$qq->where('name','like',"%$q%"))
            ->when($guard, fn($qq)=>$qq->where('guard_name',$guard))
            ->orderBy('id','desc')
            ->paginate(15)->withQueryString();

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionRequest $request)
    {
        Permission::create($request->validated());
        return redirect()->route('permissions.index')->with('success','สร้าง Permission สำเร็จ');
    }

    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return redirect()->route('permissions.show', $permission)->with('success','บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success','ลบ Permission แล้ว');
    }
}
