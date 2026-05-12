<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Role, Permission, User};
use App\Http\Requests\RoleRequest;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list roles', only: ['index']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:store roles', only: ['store']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:update roles', only: ['update']),
            new Middleware('permission:show roles', only: ['show']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request) {
   

$q = (string) $request->get('q', '');

$roles = Role::withCount('permissions')
    ->when($q, function($query) use ($q) {
        $query->where('name','like',"%{$q}%")
              ->orWhere('guard_name','like',"%{$q}%");
    })
    ->orderByDesc('id')
    ->paginate(10)
    ->withQueryString();
        $permissions = Permission::orderBy('name')->get();
        return view('access.index', [
          'roles'=>$roles, 'permissions'=>$permissions,
          'guards'=>['web','api'], 'orgs'=>[],
          // ตัวอย่าง (เลือกผู้ใช้เป้าหมายหากมี)
          'targetUser'=>null, 'userRoleIds'=>[],
        ]);
    }

    public function index(Request $request) {
        $roles = Role::withCount('permissions')
          ->when($request->q, fn($q)=>$q->where('name','like',"%{$request->q}%"))
          ->orderByDesc('id')->paginate(10)->withQueryString();
        return view('roles.index', compact('roles'));
    }

    public function create() {
        $permissions = Permission::orderBy('name')->get();
        return view('roles.create', ['permissions'=>$permissions, 'guards'=>['web','api']]);
    }

    public function store(RoleRequest $request) {
        $data = $request->validated();
        $perms = $data['permissions'] ?? [];
        unset($data['permissions']);
        $role = Role::create($data);
        if ($perms) $role->permissions()->sync($perms);
        return redirect()->route('admin.roles.show',$role)->with('success','สร้าง Role สำเร็จ');
    }

    public function show(Role $role) {
        $role->load('permissions');
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role) {
        $permissions = Permission::orderBy('name')->get();
        $role->load('permissions');
        $selected = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', [
          'role'=>$role, 'permissions'=>$permissions, 'guards'=>['web','api'], 'selected'=>$selected
        ]);
    }

    public function update(RoleRequest $request, Role $role) {
    
        $data = $request->validated();
        $perms = $data['permissions'] ?? [];
        unset($data['permissions']);
      
        $role->update($data);
        $role->permissions()->sync($perms);
  
        return redirect()->route('access.dashboard')
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
