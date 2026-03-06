<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\TestHistory;
use App\Http\Requests\TeshistoriesRequest;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Prefixes;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;


class HistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        //

        
        $q = (string) $request->get('q', '');



        $testhist = TestHistory::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('alcohol_level', 'like', "%{$q}%")->orWhere('device_sn', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

          

        return view('testhistorys.index', compact('testhist', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

                return view('testhistorys.create', [
        'employee' => Employee::orderBy('org_id')->get(),
        'orgs'  => Organization::orderBy('id')->get()
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(TeshistoriesRequest $request): RedirectResponse
    {
        //

            $data = $request->validated();
        

        // รองรับค่า datetime-local "YYYY-MM-DDTHH:MM"
        // if (is_string($data['created_date'])) {
        //     $data['created_date'] = Carbon::parse($data['created_date']);
        // }

        $data['testing_date'] = Carbon::now();
       

        $device = TestHistory::create($data);

        return redirect()->route('histories.show', $device)
            ->with('success', 'สร้างอุปกรณ์สำเร็จ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
