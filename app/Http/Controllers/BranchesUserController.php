<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Organization;

class BranchesUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request): View
    {
        $q = (string) $request->get('q', '');
        $orgId = auth()->user()->org_id ?? null;

        $branches = Branches::query()
            ->with('organize','province','tambon','amphur')
            ->when($orgId, fn($qq) => $qq->where('org_id', $orgId))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();
        return view('branchesUser.index', compact('branches','q'));
    }

    public function create(): View
    {
        $branch = new Branches();

        $orgId = auth()->user()->org_id ?? null;
         $organization = Organization::where('id',$orgId)->orderBy('name')->get();
             $provinces = \App\Http\Controllers\LocationController::provincesForForm();
        return view('branchesUser.create', compact('provinces','branch','organization'));
 
    }

    public function store(BranchRequest $request): RedirectResponse
    {
        Branches::create($request->validated());
        return redirect()->route('branchesUser.index')->with('success','บันทึกข้อมูลสาขาสำเร็จ');
    }

    public function show(Branches $branch): View
    {
        return view('branchesUser.show', compact('branch'));
    }

    public function edit(Branches $branch): View|RedirectResponse
    {
       
        $orgId = auth()->user()->org_id ?? null;
        $checkorg = Branches::where('org_id',$branch->org_id)->first();
      
        if($orgId != $checkorg->org_id){
           return redirect()->route('branchesUser.index')->with('error','ไม่อนุญาต');
        }

       
        $organization = Organization::where('id',$orgId)->orderBy('name')->get();
         $provinces = \App\Http\Controllers\LocationController::provincesForForm();
        $values = [
            'province_id' => $branch->province_id,
            'amphur_id'   => $branch->amphur_id,
            'tambon_id'   => $branch->tambon_id,
        ];



  return view('branchesUser.edit', compact('branch','provinces','values','organization'));

    
    }

    public function update(BranchRequest $request, Branches $branch): RedirectResponse
    {
        $branch->update($request->validated());
        return redirect()->route('branchesUser.index')->with('success','อัปเดตข้อมูลสาขาสำเร็จ');
    }

    public function destroy(Branches $branch): RedirectResponse
    {
        $branch->delete();
        return redirect()->route('branchesUser.index')->with('success','ลบข้อมูลสาขาสำเร็จ');
    }
}
