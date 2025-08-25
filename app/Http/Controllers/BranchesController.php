<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Amphurs;
use App\Models\Tambon;

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request): View
    {
        $q = (string) $request->get('q', '');
        $branches = Branches::query()
            ->when($q, fn($query) =>
                $query->where('brn_id','like',"%{$q}%")
                      ->orWhere('name','like',"%{$q}%")
                      ->orWhere('org_id','like',"%{$q}%")
                      ->orWhere('address','like',"%{$q}%")
            )
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('branches.index', compact('branches','q'));
    }

    public function create(): View
    {
        $branch = new Branches();

             $provinces = \App\Http\Controllers\LocationController::provincesForForm();
        return view('branches.create', compact('provinces','branch'));
 
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

         $provinces = \App\Http\Controllers\LocationController::provincesForForm();
        $values = [
            'province_id' => $branch->province_id,
            'amphur_id'   => $branch->amphur_id,
            'tambon_id'   => $branch->tambon_id,
        ];


    //         $provinces = LocationController::provincesForForm();
    // $amphurs   = Amphurs::where('province_id', $branch->province_id)->orderBy('name')->get(['id','name']);
    // $tambons   = Tambon::where('amphur_id', $branch->amphur_id)->orderBy('name')->get(['id','name']);

    // return view('branches.edit', [
    //     'branch'    => $branch,
    //     'provinces' => $provinces,
    //     'amphurs'   => $amphurs,
    //     'tambons'   => $tambons,
    //     'values'    => [
    //         'province_id' => $branch->province_id,
    //         'amphur_id'   => $branch->amphur_id,
    //         'tambon_id'   => $branch->tambon_id,
    //     ],
    // ]);
          

  return view('branches.edit', compact('branch','provinces','values'));

    
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
