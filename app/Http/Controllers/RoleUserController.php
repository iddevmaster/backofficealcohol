<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Role, Permission, User};
use App\Http\Requests\RoleRequest;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index(Request $request) {

        $q = (string) $request->get('q', '');
        $orgId = auth()->user()->org_id ?? null;
        $roles = Role::withCount('permissions')
        ->when($orgId, fn($qq) => $qq->where('org_id', $orgId))
          ->when($request->q, fn($q)=>$q->where('name','like',"%{$request->q}%"))
          
          ->orderByDesc('id')->paginate(10)->withQueryString();
        return view('rolesUser.index', compact('roles','q'));




    }

    public function create() {
        $permissions = Permission::orderBy('name')->get();
        $orgId = auth()->user()->org_id ?? null;
        return view('rolesUser.create', ['permissions'=>$permissions, 'guards'=>['web','api'],'org_id' =>$orgId]);
    }

    public function store(RoleRequest $request) {
        $data = $request->validated();
        $perms = $data['permissions'] ?? [];
        unset($data['permissions']);
        $role = Role::create($data);
        if ($perms) $role->permissions()->sync($perms);
        return redirect()->route('rolesUser.index')->with('success','สร้าง Role สำเร็จ');
    }

    public function show(Role $role) {
        $role->load('permissions');
        return view('rolesUser.show', compact('role'));
    }

    public function edit(Role $role) {
        $permissions = Permission::orderBy('name')->get();
        $role->load('permissions');
        $selected = $role->permissions->pluck('id')->toArray();
        return view('rolesUser.edit', [
          'role'=>$role, 'permissions'=>$permissions, 'guards'=>['web','api'], 'selected'=>$selected
        ]);
    }

    public function update(RoleRequest $request, Role $role) {
    
        $data = $request->validated();
        $perms = $data['permissions'] ?? [];
        unset($data['permissions']);
      
        $role->update($data);
        $role->permissions()->sync($perms);
  
        return redirect()->route('rolesUser.index')
       ->with('success', 'บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Role $role) {
        $role->delete();
        return redirect()->route('roles.index')->with('success','ลบ Role แล้ว');
    }

    // มอบ role ให้ผู้ใช้ (ตัวอย่าง)
    public function syncUserRoles(Request $request, User $user) {
        $ids = $request->input('roles', []);
        $user->roles()->sync($ids);
        return back()->with('success','อัปเดต Roles ให้ผู้ใช้แล้ว');
    }
}
