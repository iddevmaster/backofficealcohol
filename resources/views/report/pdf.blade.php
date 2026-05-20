<!DOCTYPE html>
<html lang="th">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>รายงานผลการตรวจวัดแอลกอฮอล์</title>
    <style>
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/Sarabun-Regular.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/Sarabun-Bold.ttf') }}") format('truetype');
        }
        
        @page {
            size: A4 landscape;
            margin: 15mm 15mm 15mm 15mm;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            color: #1e293b;
            line-height: 1.4;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .header td {
            border: none;
            padding: 0;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
        }

        .subtitle {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }

        .meta-info {
            text-align: right;
            font-size: 12px;
            color: #64748b;
        }



        /* Main Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
            font-size: 12px;
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }

        .data-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            font-size: 12px;
            color: #334155;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
        }

        .badge-pass {
            background-color: #dcfce7;
            color: #15803d;
        }

        .badge-fail {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-semibold {
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: -10mm;
            left: 0;
            right: 0;
            height: 10mm;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="title">รายงานระบบตู้เป่าแอลกอฮอล์</div>
                    <div class="subtitle">สรุปผลการตรวจวัดแอลกอฮอล์ของพนักงาน</div>
                </td>
                <td class="meta-info">
                    วันที่ออกรายงาน: {{ now('Asia/Bangkok')->format('d/m/Y H:i') }}<br>
                    จำนวนรายการทั้งหมด: {{ number_format(count($reports)) }} รายการ
                </td>
            </tr>
        </table>
    </div>


    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">#</th>
                <th style="width: 12%;">รหัสพนักงาน</th>
                <th style="width: 20%;">ชื่อ - สกุล</th>
                <th style="width: 15%;">หน่วยงาน</th>
                <th style="width: 12%;">สาขา</th>
                <th style="width: 12%;">SN เครื่อง</th>
                <th style="width: 10%;" class="text-center">ระดับแอลกอฮอล์</th>
                <th style="width: 8%;" class="text-center">สถานะ</th>
                <th style="width: 16%;">วันที่ตรวจ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $row)
                @php
                    $isPass = $row->alcohol_level <= 0;
                    $fullName = trim(($row->first_name ?? '') . ' ' . ($row->last_name ?? ''));
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $row->emp_id ?? '-' }}</td>
                    <td class="font-semibold">{{ $fullName ?: '-' }}</td>
                    <td>{{ $row->department_name ?? '-' }}</td>
                    <td>{{ $row->branch_name ?? '-' }}</td>
                    <td>{{ $row->device_sn }}</td>
                    <td class="text-center font-semibold" style="color: {{ $isPass ? '#16a34a' : '#dc2626' }};">
                        {{ number_format($row->alcohol_level, 2) }} mg/L
                    </td>
                    <td class="text-center">
                        <span class="status-badge {{ $isPass ? 'badge-pass' : 'badge-fail' }}">
                            {{ $isPass ? 'ผ่าน' : 'ไม่ผ่าน' }}
                        </span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($row->testing_date)->format('d/m/Y H:i') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 30px; color: #64748b;">
                        ไม่พบข้อมูลรายงาน
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer Page Numbers -->
    <div class="footer">
        ระบบตู้เป่าแอลกอฮอล์ - รายงานสรุปผลการตรวจวัด
    </div>

</body>
</html>
