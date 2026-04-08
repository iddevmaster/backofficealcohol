<x-app-layout>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Report</h1>

</div>

<div class="space-y-6">

    {{-- Page Title --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">รายงานระบบตู้เป่าแอลกอฮอล์</h1>
            <p class="text-sm text-slate-500">สรุปผลการตรวจวัดแอลกอฮอล์ของพนักงาน</p>
        </div>

        <a href="#"
           class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm">
            Export Excel
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">รายการทั้งหมด</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalCount) }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">ผ่าน</p>
            <h3 class="mt-2 text-3xl font-bold text-green-600">{{ number_format($passCount) }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">ไม่ผ่าน</p>
            <h3 class="mt-2 text-3xl font-bold text-red-600">{{ number_format($failCount) }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">วันนี้</p>
            <h3 class="mt-2 text-3xl font-bold text-indigo-600">{{ number_format($todayCount) }}</h3>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <form method="GET" action="{{ route('report.report') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">ค้นหา</label>
                    <input type="text"
                           name="keyword"
                           value="{{ request('keyword') }}"
                           placeholder="ชื่อพนักงาน / รหัส / SN"
                           class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">องค์กร</label>
                    <select name="org_id"
                            class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">ทั้งหมด</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ request('org_id') == $org->id ? 'selected' : '' }}>
                                {{ $org->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">วันที่เริ่มต้น</label>
                    <input type="date"
                           name="date_from"
                           value="{{ request('date_from') }}"
                           class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">วันที่สิ้นสุด</label>
                    <input type="date"
                           name="date_to"
                           value="{{ request('date_to') }}"
                           class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">สถานะ</label>
                    <select name="result_status"
                            class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">ทั้งหมด</option>
                        <option value="pass" {{ request('result_status') == 'pass' ? 'selected' : '' }}>ผ่าน</option>
                        <option value="fail" {{ request('result_status') == 'fail' ? 'selected' : '' }}>ไม่ผ่าน</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                <button type="submit"
                        class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                    ค้นหา
                </button>

                <a href="{{ route('report.report') }}"
                   class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold">
                    ล้างค่า
                </a>

                <a href="{{ route('report.alcohol.export', request()->query()) }}"
   class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm">
    Export Excel
</a>
            </div>
        </form>
    </div>

    {{-- Report Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">รายการผลตรวจ</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">รูป</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">รหัสพนักงาน</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">ชื่อ - สกุล</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">หน่วยงาน</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">สาขา</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">SN เครื่อง</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">ระดับแอลกอฮอล์</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">สถานะ</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">วันที่ตรวจ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reports as $index => $row)
                        @php
                            $isPass = $row->alcohol_level <= 0;
                            $fullName = trim(($row->first_name ?? '') . ' ' . ($row->last_name ?? ''));
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                {{ $reports->firstItem() + $index }}
                            </td>

                            <td class="px-4 py-3">
                                @if($row->testing_image)
                                    <img src="{{ asset($row->testing_image) }}"
                                         alt="testing image"
                                         class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-xs">
                                        ไม่มีรูป
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-slate-700">{{ $row->emp_id ?? '-' }}</td>

                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ $fullName ?: '-' }}</div>
                            </td>

                            <td class="px-4 py-3 text-slate-700">{{ $row->department_name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $row->branch_name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $row->device_sn }}</td>

                            <td class="px-4 py-3">
                                <div class="font-semibold {{ $isPass ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($row->alcohol_level, 2) }} mg/L
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                @if($isPass)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        ผ่าน
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        ไม่ผ่าน
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-slate-700">
                                {{ \Carbon\Carbon::parse($row->testing_date)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-10 text-center text-slate-500">
                                ไม่พบข้อมูลรายงาน
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200">
            {{ $reports->links() }}
        </div>
    </div>
</div>

</x-app-layout>
