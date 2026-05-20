<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class AlcoholReportExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('test_histories as th')
            ->leftJoin('employees as e', 'th.tester_id', '=', 'e.id')
            ->leftJoin('organizations as org', 'th.org_id', '=', 'org.id')
            ->leftJoin('departments as d', 'e.dpm_id', '=', 'd.id')
            ->leftJoin('branches as b', 'e.brn_id', '=', 'b.id')
            ->select(
                'e.emp_id',
                DB::raw("CONCAT(e.first_name, ' ', e.last_name) as full_name"),
                'd.name as department',
                'b.name as branch',
                'org.name as organization',
                'th.device_sn',
                'th.alcohol_level',
                DB::raw("
                    CASE
                        WHEN th.alcohol_level <= 0 THEN 'ผ่าน'
                        ELSE 'ไม่ผ่าน'
                    END as status
                "),
                'th.testing_date'
            );

        // 🔎 filter เหมือนหน้า report
        if (!empty($this->filters['keyword'])) {
            $keyword = $this->filters['keyword'];

            $query->where(function ($q) use ($keyword) {
                $q->where('e.emp_id', 'like', "%{$keyword}%")
                  ->orWhere('e.first_name', 'like', "%{$keyword}%")
                  ->orWhere('e.last_name', 'like', "%{$keyword}%")
                  ->orWhere('th.device_sn', 'like', "%{$keyword}%");
            });
        }

        if (!empty($this->filters['org_id'])) {
            $query->where('th.org_id', $this->filters['org_id']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('th.testing_date', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('th.testing_date', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['result_status'])) {
            if ($this->filters['result_status'] == 'pass') {
                $query->where('th.alcohol_level', '<=', 0);
            } elseif ($this->filters['result_status'] == 'fail') {
                $query->where('th.alcohol_level', '>', 0);
            }
        }

        return $query->orderByDesc('th.testing_date')->get();
    }

    public function map($row): array
    {
        return [
            $row->emp_id ?? '-',
            $row->full_name ?: '-',
            $row->department ?? '-',
            $row->branch ?? '-',
            $row->organization ?? '-',
            $row->device_sn,
            strval(number_format((float) $row->alcohol_level, 2)),
            $row->status,
            $row->testing_date ? \Carbon\Carbon::parse($row->testing_date)->format('d/m/Y H:i') : '-',
        ];
    }

    public function headings(): array
    {
        return [
            'รหัสพนักงาน',
            'ชื่อ-สกุล',
            'แผนก',
            'สาขา',
            'องค์กร',
            'Serial Number',
            'ระดับแอลกอฮอล์ (mg/L)',
            'สถานะ',
            'วันที่ตรวจ'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => '@', // Column G is 'ระดับแอลกอฮอล์' and we format it as Text (@)
        ];
    }
}
