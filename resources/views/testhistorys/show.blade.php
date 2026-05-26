<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ALT E-Receipt #{{ str_pad($history->id, 6, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }

        .mono {
            font-family: 'IBM Plex Mono', monospace;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col items-center py-10 px-4">

    @php
        $isPass = $history->alcohol_level <= 0;
        $employee = $history->employee;
        $empCode = $employee->emp_id ?? '-';
        $testDate = $history->testing_date ? \Carbon\Carbon::parse($history->testing_date) : null;
        $nowDate = \Carbon\Carbon::parse(now('Asia/Bangkok'))->format('d/m/Y  H:i:s');
        $imgSrc = $history->testing_image
            ? asset(
                \Illuminate\Support\Str::startsWith($history->testing_image, 'storage/')
                    ? $history->testing_image
                    : 'storage/' . $history->testing_image,
            )
            : null;
        $passColor = $isPass ? '#059669' : '#e11d48';
        $passLabel = $isPass ? 'ผ่านเกณฑ์' : 'ไม่ผ่านเกณฑ์';
        $passSymbol = $isPass ? '✔' : '✖';
    @endphp

    {{-- Web Title & Icon (No bar) --}}
    <div class="mb-6">
        <div class="flex items-center justify-center gap-2.5 mb-4">
            <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center shadow-md shadow-indigo-200">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <span class="text-2xl font-extrabold text-slate-800 tracking-wider">ALT Alcohol Tester System</span>
        </div>
        <div class="text-xl font-extrabold text-slate-800 tracking-wider text-center">
            ใบรับรองการตรวจวัดแอลกอฮอล์ (Test Receipt)
        </div>
    </div>

    {{-- ===== RECEIPT CARD (capture target) ===== --}}
    <div id="receipt-container" style="padding: 5px;">
        <div id="receipt-card"
            style="width:440px; background:#fff; border-radius:16px; overflow:hidden;
                border:1px solid #5f5f5f;">

            {{-- Top color stripe --}}
            <div
                style="height:6px; background:{{ $isPass ? 'linear-gradient(90deg,#34d399,#14b8a6)' : 'linear-gradient(90deg,#fb7185,#ef4444)' }};">
            </div>

            <div style="padding:28px 32px 24px;">

                {{-- Header --}}
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:20px;">
                    <div>
                        <div
                            style="font-size:10px; font-weight:700; letter-spacing:.12em; color:#94a3b8; text-transform:uppercase; margin-bottom:4px;">
                            E-Receipt</div>
                        <div style="font-size:15px; font-weight:800; color:#1e293b; line-height:1.3;">
                            ใบรับรองการตรวจวัดแอลกอฮอล์</div>
                    </div>
                    <div
                        style="font-family:'IBM Plex Mono',monospace; font-size:11px; font-weight:700; color:#4f46e5;
                      background:#eef2ff; border:1px solid #c7d2fe; padding:4px 10px; border-radius:8px; white-space:nowrap; margin-top:2px;">
                        #{{ str_pad($history->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                {{-- Dashed divider --}}
                <div style="border-top:1.5px dashed #e2e8f0; margin-bottom:20px;"></div>

                {{-- Employee --}}
                <div
                    style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:20px;">
                    {{-- Left Column: Avatar & Basic Info --}}
                    <div style="display:flex; align-items:center; gap:14px; flex:1; min-width:0;">
                        {{-- Avatar --}}
                        @if ($employee && $employee->image)
                            <img src="{{ asset('storage/' . $employee->image) }}" alt="photo"
                                style="width:48px; height:48px; border-radius:10px; object-fit:cover; border:1px solid #e2e8f0; flex-shrink:0;">
                        @else
                            <div
                                style="width:48px; height:48px; border-radius:10px; background:linear-gradient(135deg,#475569,#1e293b);
                            display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:16px; flex-shrink:0;">
                                {{ $employee ? mb_substr($employee->first_name, 0, 1, 'UTF-8') : '?' }}
                            </div>
                        @endif

                        <div style="min-width:0;">
                            <div
                                style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; margin-bottom:2px;">
                                พนักงาน</div>
                            <div style="font-size:14px; font-weight:700; color:#1e293b; ">
                                {{ $employee ? trim(($employee->prefix?->name ?? '') . ' ' . $employee->first_name . ' ' . $employee->last_name) : 'ไม่ทราบชื่อ' }}
                            </div>
                            <div
                                style="font-family:'IBM Plex Mono',monospace; font-size:11px; color:#64748b; margin-top:2px;">
                                {{ $empCode }}</div>
                        </div>
                    </div>

                    {{-- Right Column: Employee Org Info --}}
                    <div
                        style="flex-shrink:0; text-align:right; font-size:11px; color:#475569; line-height:1.5; max-width:180px;">
                        @if ($employee)
                            @if ($employee->department)
                                <div><span style="color:#94a3b8; font-weight:600;">แผนก:</span>
                                    {{ $employee->department->name }}</div>
                            @endif
                            @if ($employee->Branches)
                                <div><span style="color:#94a3b8; font-weight:600;">สาขา:</span>
                                    {{ $employee->Branches->name }}</div>
                            @endif
                            @if ($employee->organization)
                                <div><span style="color:#94a3b8; font-weight:600;">องค์กร:</span>
                                    {{ $employee->organization->name }}</div>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Detail rows --}}
                @php
                    $rows = [
                        [
                            'label' => 'วันที่ตรวจ',
                            'value' => $testDate ? $testDate->format('d/m/Y  H:i:s') : '-',
                            'mono' => true,
                        ],
                        ['label' => 'อุปกรณ์ SN', 'value' => $history->device_sn, 'mono' => true, 'badge' => true],
                        ['label' => 'สาขา', 'value' => $history->branch->name ?? '-', 'mono' => false],
                        ['label' => 'องค์กร', 'value' => $history->organization->name ?? '-', 'mono' => false],
                    ];
                @endphp

                <div style="margin-bottom:20px;">
                    @foreach ($rows as $row)
                        <div
                            style="display:flex; justify-content:space-between; align-items:center; padding:7px 0; border-bottom:1px solid #f1f5f9; font-size:13px;">
                            <span style="color:#64748b;">{{ $row['label'] }}</span>
                            @if (!empty($row['badge']))
                                <span
                                    style="font-family:'IBM Plex Mono',monospace; font-size:11px; font-weight:600; color:#334155; background:#f1f5f9; padding:2px 8px; border-radius:6px;">{{ $row['value'] }}</span>
                            @else
                                <span
                                    style="font-family:{{ $row['mono'] ? '\'IBM Plex Mono\',monospace' : 'inherit' }}; font-size:{{ $row['mono'] ? '11px' : '13px' }}; font-weight:600; color:#1e293b;">{{ $row['value'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Dashed divider --}}
                <div style="border-top:1.5px dashed #e2e8f0; margin-bottom:20px;"></div>

                {{-- Result block --}}
                <div
                    style="display:flex; align-items:center; justify-content:space-between;
                    background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; margin-bottom:20px;">
                    <div>
                        <div
                            style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.1em; margin-bottom:6px;">
                            ระดับแอลกอฮอล์</div>
                        <div
                            style="font-family:'IBM Plex Mono',monospace; font-size:32px; font-weight:800; color:{{ $passColor }}; line-height:1;">
                            @if ($history->alcohol_level > 0)
                                {{ number_format($history->alcohol_level * 1000, 2) }}<span
                                    style="font-size:14px; color:#94a3b8; font-weight:600; margin-left:4px;">mg%</span>
                            @elseif ($history->alcohol_level == 0)
                                0<span
                                    style="font-size:14px; color:#94a3b8; font-weight:600; margin-left:4px;">mg%</span>
                            @else
                                ERROR
                            @endif
                        </div>
                        <div style="font-size:10px; color:#94a3b8; margin-top:6px;">เกณฑ์มาตรฐาน: ≤ 0 mg%</div>
                    </div>
                    <div
                        style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
                      background:{{ $isPass ? '#ecfdf5' : '#fff1f2' }}; border:1.5px solid {{ $isPass ? '#a7f3d0' : '#fecdd3' }};
                      border-radius:12px; padding:14px 18px; color:{{ $passColor }};">
                        <span style="font-size:22px; line-height:1;">{{ $passSymbol }}</span>
                        <span style="font-size:11px; font-weight:800; letter-spacing:.04em;">{{ $passLabel }}</span>
                    </div>
                </div>

                {{-- Testing image --}}
                @if ($imgSrc)
                    <div style="margin-bottom:20px;">
                        <div
                            style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.1em; margin-bottom:8px;">
                            ภาพถ่ายการทดสอบ</div>
                        <div
                            style="border-radius:10px; overflow:hidden; border:1px solid #e2e8f0; background:#f1f5f9; aspect-ratio:16/9;">
                            <img src="{{ $imgSrc }}" alt="Testing Image"
                                style="width:100%; height:100%; object-fit:cover; display:block;">
                        </div>
                    </div>
                @endif

                {{-- Footer --}}
                <div style="text-align:center; padding-top:8px;">
                    <div
                        style="font-family:'IBM Plex Mono',monospace; font-size:9px; color:#cbd5e1; text-transform:uppercase; letter-spacing:.12em;">
                        Alcohol Tester System (ALT) &bull; {{ $nowDate }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- ===== END RECEIPT CARD ===== --}}

    {{-- Tool bar (outside capture zone) --}}
    <div class="w-full max-w-sm mt-6 flex items-center justify-center">
        <button id="btn-download" onclick="downloadReceipt()"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow transition cursor-pointer">
            ⬇ ดาวน์โหลด PNG
        </button>
    </div>

    <script src="https://unpkg.com/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        function downloadReceipt() {
            const btn = document.getElementById('btn-download');
            btn.disabled = true;
            btn.textContent = 'กำลังสร้าง...';

            const el = document.getElementById('receipt-container');

            html2canvas(el, {
                scale: 3,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                logging: false,
                width: el.offsetWidth,
                height: el.offsetHeight,
                scrollX: 0,
                scrollY: 0
            }).then(canvas => {
                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download =
                    'e_receipt_{{ $empCode }}_{{ $testDate ? $testDate->format('Ymd_His') : 'na' }}.png';
                link.click();

                btn.disabled = false;
                btn.textContent = '⬇ ดาวน์โหลด PNG';
            }).catch(() => {
                btn.disabled = false;
                btn.textContent = '⬇ ดาวน์โหลด PNG';
            });
        }
    </script>
</body>

</html>
