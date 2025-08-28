<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Prefixes;
use App\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
      

    $q = (string) $request->get('q', '');

$users = User::query()
    ->with('role','organize') // ผูก role มาพร้อมกัน ป้องกัน N+1
    ->when($q, function ($qr) use ($q) {
        $qr->where(function ($w) use ($q) {
            $w->where('username', 'like', "%{$q}%")
              ->orWhere('first_name', 'like', "%{$q}%")
              ->orWhere('last_name', 'like', "%{$q}%")
              ->orWhere('role_id', 'like', "%{$q}%")
              ->orWhere('org_id', 'like', "%{$q}%");
        })
        // ค้นหาจากชื่่อ role ด้วย
        ->orWhereHas('role', function ($r) use ($q) {
            $r->where('name', 'like', "%{$q}%");
        })
        ->orWhereHas('organize', function ($s) use ($q) {
            $s->where('name', 'like', "%{$q}%");
        });
    })
    ->latest('id')
    ->paginate(10)
    ->withQueryString();

        return view('users.index', compact('users','q'));
    }

    public function create()
    {
    
         return view('users.create', [
        'roles' => Role::orderBy('name')->get(),
        'orgs'  => Organization::orderBy('id')->get(),
        'departments'  => Department::orderBy('name')->get(),
        'prefixs'  => Prefixes::orderBy('id')->get(),
    ]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        User::create($data);

        return redirect()->route('users.index')->with('success','สร้างผู้ใช้สำเร็จ');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
       
        return view('users.edit', [
        'user'  => $user,
        'roles' => Role::orderBy('name')->get(),
        'orgs'  => Organization::orderBy('id')->get(),
        'departments'  => Department::orderBy('name')->get(),
        'prefixs'  => Prefixes::orderBy('id')->get(),
    ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        // ถ้าไม่กรอกรหัสผ่านใหม่ อย่าทับของเดิม
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success','อัปเดตผู้ใช้สำเร็จ');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','ลบผู้ใช้สำเร็จ');
    }
}
