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
use App\Models\Device;
use App\Models\Organization;
use App\Models\Prefixes;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Log;



class HistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        //

        $q     = $request->get('q');


$test = TestHistory::with('employee')->get();



        return view('testhistorys.index', compact('test', 'q'));
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
     public function filteredUsersTest(Request $request): JsonResponse
    {
    
        // $testhist [ {n:'01',name:'นายสมชาย ใจดี',   id:'EMP001',sn:'BRZ-2024-001',lvl:0.00,date:'9 มี.ค. 68  07:02',color:'#6c63ff',init:'สจ'},
        //       {n:'02',name:'นางสมหญิง รักงาน', id:'EMP002',sn:'BRZ-2024-001',lvl:0.00,date:'9 มี.ค. 68  07:15',color:'#00b4d8',init:'สง'},
        //       {n:'03',name:'นายวิชัย มั่นคง',  id:'EMP003',sn:'BRZ-2024-002',lvl:0.52,date:'9 มี.ค. 68  07:30',color:'#f72585',init:'วม'},
        //       {n:'04',name:'นางสาวอรทัย สดใส', id:'EMP004',sn:'BRZ-2024-002',lvl:0.00,date:'9 มี.ค. 68  07:45',color:'#06d6a0',init:'อส'},
        //       {n:'05',name:'นายประสิทธิ์ เก่งกาจ',id:'EMP005',sn:'BRZ-2024-003',lvl:0.18,date:'9 มี.ค. 68  08:00',color:'#ffd166',init:'ปก'},
        //       {n:'06',name:'นายสมชาย ใจดี',   id:'EMP001',sn:'BRZ-2024-003',lvl:0.00,date:'9 มี.ค. 68  14:00',color:'#6c63ff',init:'สจ'},
        //     ], 
        $datas = [];

        $data = TestHistory::where('org_id',1)->get();

             foreach ($data as $index => $tests) {
                   $getpem = Employee::where('id',$tests->tester_id)->first();
                   $deve = Device::where('serial_num',$tests->device_sn)->first();
                   $org = Organization::where('id',$tests->org_id)->first();
                        $datas[$index]['id'] = $tests->id;
                        $datas[$index]['f_name'] = $getpem->first_name;
                        $datas[$index]['l_name'] = $getpem->last_name;
                        $datas[$index]['prefix_id'] = $getpem->prefix_id;
                        $datas[$index]['user_code'] = $getpem->user_code;
                        $datas[$index]['alcohol_level'] = $tests->alcohol_level;
                        $datas[$index]['testing_image'] = $tests->testing_image;
                        $datas[$index]['device_sn'] = $tests->device_sn;
                        $datas[$index]['device_name'] = $deve->serial_num;
                        $datas[$index]['org_name'] = $org->name;
                        $datas[$index]['org_id'] = $org->org_id;
                        $datas[$index]['created_at'] = $tests->created_at;
                  
               
                }

                  return response()->json([
            'success' => true,
            'data'    => $datas,
        ]);
    }
}
