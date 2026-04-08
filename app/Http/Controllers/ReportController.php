<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\AlcoholReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //

          public function report(Request $request)
    {


     $query = DB::table('test_histories as th')
            ->leftJoin('employees as e', 'th.tester_id', '=', 'e.id')
            ->leftJoin('organizations as org', 'th.org_id', '=', 'org.id')
            ->leftJoin('departments as d', 'e.dpm_id', '=', 'd.id')
            ->leftJoin('branches as b', 'e.brn_id', '=', 'b.id')
            ->select(
                'th.id',
                'th.device_sn',
                'th.alcohol_level',
                'th.testing_image',
                'th.testing_date',
                'th.created_at',
                'e.emp_id',
                'e.prefix_id',
                'e.first_name',
                'e.last_name',
                'org.name as org_name',
                'd.name as department_name',
                'b.name as branch_name'
            );

        // ค้นหาจากชื่อ / รหัสพนักงาน / serial number
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('e.emp_id', 'like', "%{$keyword}%")
                  ->orWhere('e.first_name', 'like', "%{$keyword}%")
                  ->orWhere('e.last_name', 'like', "%{$keyword}%")
                  ->orWhere(DB::raw("CONCAT(e.first_name, ' ', e.last_name)"), 'like', "%{$keyword}%")
                  ->orWhere('th.device_sn', 'like', "%{$keyword}%");
            });
        }

        // filter องค์กร
        if ($request->filled('org_id')) {
            $query->where('th.org_id', $request->org_id);
        }

        // filter วันที่เริ่ม
        if ($request->filled('date_from')) {
            $query->whereDate('th.testing_date', '>=', $request->date_from);
        }

        // filter วันที่สิ้นสุด
        if ($request->filled('date_to')) {
            $query->whereDate('th.testing_date', '<=', $request->date_to);
        }

        // filter สถานะ
        // ตัวอย่างเกณฑ์:
        // ผ่าน = alcohol_level <= 0
        // ไม่ผ่าน = alcohol_level > 0
        if ($request->filled('result_status')) {
            if ($request->result_status === 'pass') {
                $query->where('th.alcohol_level', '<=', 0);
            } elseif ($request->result_status === 'fail') {
                $query->where('th.alcohol_level', '>', 0);
            }
        }

        $reports = $query->orderByDesc('th.testing_date')->paginate(15)->withQueryString();

        // summary cards
        $summaryBase = DB::table('test_histories');

        if ($request->filled('org_id')) {
            $summaryBase->where('org_id', $request->org_id);
        }
        if ($request->filled('date_from')) {
            $summaryBase->whereDate('testing_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $summaryBase->whereDate('testing_date', '<=', $request->date_to);
        }

        $totalCount = (clone $summaryBase)->count();
        $passCount  = (clone $summaryBase)->where('alcohol_level', '<=', 0)->count();
        $failCount  = (clone $summaryBase)->where('alcohol_level', '>', 0)->count();
        $todayCount = (clone $summaryBase)->whereDate('testing_date', now()->toDateString())->count();

        $organizations = DB::table('organizations')->select('id', 'name')->orderBy('name')->get();

        return view('report.index', compact(
            'reports',
            'organizations',
            'totalCount',
            'passCount',
            'failCount',
            'todayCount'
        ));

    }


    public function export(Request $request)
{
    return Excel::download(
        new AlcoholReportExport($request->all()),
        'alcohol_report_' . now()->format('Ymd_His') . '.xlsx'
    );
}
}
