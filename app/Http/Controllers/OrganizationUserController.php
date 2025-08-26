<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Support\Str;

class OrganizationUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = (string) $request->get('q', '');
        $orgs = Organization::query()
            ->when($q, fn($qr) => $qr->where('name','like',"%{$q}%")
                                      ->orWhere('org_id','like',"%{$q}%"))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('organizations.index', compact('orgs','q'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(OrganizationRequest $request)
    {
        $data = $request->validated();

        // ถ้าไม่ส่ง org_id มา ให้ gen UUID อัตโนมัติ
        if (empty($data['org_id'])) {
            $data['org_id'] = (string) Str::uuid();
        }

        // รับค่าจาก checkbox/switch ให้เป็น boolean ชัวร์ ๆ
        $data['status'] = $request->boolean('status');

        Organization::create($data);
        return redirect()->route('organizations.index')->with('success','บันทึกองค์กรสำเร็จ');
    }

    public function show(Organization $organization)
    {
        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    public function update(OrganizationRequest $request, Organization $organization)
    {
        $data = $request->validated();

        // ไม่บังคับแก้ org_id แต่ถ้าฟอร์มว่างให้คงค่าเดิม
        if (empty($data['org_id'])) {
            $data['org_id'] = $organization->org_id;
        }

        $data['status'] = $request->boolean('status');
       
        $organization->update($data);
        return redirect()->route('organizations.index')->with('success','อัปเดตองค์กรสำเร็จ');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success','ลบองค์กรสำเร็จ');
    }
}
