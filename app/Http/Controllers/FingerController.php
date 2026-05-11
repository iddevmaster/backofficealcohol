<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\{Employee, Branches, Department, Fingerprints, Organization, Prefixes};
use Illuminate\Http\JsonResponse;
use Log;
use Carbon\Carbon;


use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FingerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list finger', only: ['index']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $q = $request->get('q');
        $orgId = $request->get('org_id');

        $employees = Employee::query()
            ->with(['organization', 'branches', 'department'])
            ->when(!$isAdmin, fn($qq) => $qq->where('org_id', $user->org_id))
            ->when($isAdmin && $orgId, fn($qq) => $qq->where('org_id', $orgId))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('emp_id', 'like', "%{$q}%")
                        ->orWhere('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhereHas('branches', fn($b) => $b->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('department', fn($d) => $d->where('name', 'like', "%{$q}%"));
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $organizations = Organization::query()
            ->when(!$isAdmin, fn($qq) => $qq->where('id', $user->org_id))
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('fing.index', compact('employees', 'organizations', 'q', 'orgId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function filteredUsers(Request $request): JsonResponse
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $filters = $request->validate([
            'search' => 'nullable|string|max:100'
        ]);

        $employees = Employee::query()
            ->when(!$isAdmin, fn($q) => $q->where('org_id', $user->org_id))
            ->get();


        $datas = [];
        foreach ($employees as $index => $employs) {

            $fingerNos = Fingerprints::where('emp_id', $employs->id)
                ->orderBy('finger_no', 'asc')
                ->get(['id', 'finger_no', 'note'])
                ->toArray();

            $x = Fingerprints::where('emp_id', $employs->id)->count();


            $datas['data'][$index]['id'] = $employs->id;
            $datas['data'][$index]['emp_id'] = $employs->emp_id;
            $datas['data'][$index]['prefix_id'] = $employs->prefix_id;
            $datas['data'][$index]['first_name'] = $employs->first_name;
            $datas['data'][$index]['last_name'] = $employs->last_name;
            $datas['data'][$index]['name'] = $employs->first_name . ' ' . $employs->last_name;
            $datas['data'][$index]['phone'] = $employs->phone;
            $datas['data'][$index]['enrolled'] = $x;
            $datas['data'][$index]['fingers'] = $fingerNos;
            $datas['data'][$index]['color'] = '';
        }





        return response()->json([
            'success' => true,
            'data' => $datas,
        ]);
    }



    public function filteredUsersFromHm(Request $request): JsonResponse
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $filters = $request->validate([
            'search' => 'nullable|string|max:100'
        ]);

        $employees = Employee::query()
            ->when(!$isAdmin, fn($q) => $q->where('org_id', $user->org_id))
            ->get();


        $datas = [];
        foreach ($employees as $index => $employs) {



            $fingerNos = Fingerprints::where('emp_id', $employs->id)
                ->orderBy('finger_no', 'asc')->get(['id', 'finger_no', 'note']);





            $datas[$index]['id'] = $employs->id;
            $datas[$index]['user_code'] = $employs->user_code;
            $datas[$index]['emp_id'] = $employs->emp_id;
            $datas[$index]['prefix_id'] = $employs->prefix_id;
            $datas[$index]['first_name'] = $employs->first_name;
            $datas[$index]['last_name'] = $employs->last_name;
            $datas[$index]['phone'] = $employs->phone;
            $datas[$index]['enrolled'] = 3;
            $datas[$index]['fingers'] = $fingerNos;

        }





        return response()->json([
            'success' => true,
            'data' => $datas,
        ]);
    }


    public function saveFinger(Request $request): JsonResponse
    {
        //
        // \Log::info($request->all());

        try {
            $current = Carbon::now();
            $formpdpa = Fingerprints::create([
                'emp_id' => $request->id,
                'finger_no' => $request->finger_index,
                'fingerprint_code' => $request->fingerprint_code,
                'note' => $request->finger_label ?? '',
                'timestamp' => $current,
            ]);


            return response()->json([
                'success' => true,
                'data' => $formpdpa,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'data' => $th->getMessage(),
            ], 500);
        }
    }


    public function checkFinger(Request $request): JsonResponse
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $employees = Employee::where('user_code', $request->user_code)
            ->when(!$isAdmin, fn($q) => $q->where('org_id', $user->org_id))
            ->limit(1)
            ->get();
        if (count($employees) > 0) {
            $status = true;
        } else {

            $status = false;
        }
        $datas = [];
        foreach ($employees as $index => $employs) {



            $fingerNos = Fingerprints::where('emp_id', $employs->id)
                ->orderBy('finger_no', 'asc')->get(['id', 'finger_no', 'note']);





            $datas[$index]['id'] = $employs->id;
            $datas[$index]['user_code'] = $employs->user_code;
            $datas[$index]['emp_id'] = $employs->emp_id;
            $datas[$index]['prefix_id'] = $employs->prefix_id;
            $datas[$index]['first_name'] = $employs->first_name;
            $datas[$index]['last_name'] = $employs->last_name;
            $datas[$index]['phone'] = $employs->phone;
            $datas[$index]['enrolled'] = 3;
            $datas[$index]['fingers'] = $fingerNos;

        }





        return response()->json([
            'success' => $status,
            'data' => $datas,
        ]);
    }


    public function delfingerall(Request $request): JsonResponse
    {
        //


        $datas = [];
        Fingerprints::where('emp_id', $request->id)->delete();
        return response()->json([
            'success' => true,
            'data' => $datas,
        ]);
    }

    public function delfingerone(Request $request): JsonResponse
    {
        Fingerprints::where('id', $request->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'ลบลายนิ้วมือสำเร็จ'
        ]);
    }

}
