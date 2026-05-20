<x-app-layout>
  <div class="space-y-6 px-4 py-8 max-w-7xl mx-auto">

    {{-- Page Title --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">ประวัติการสแกนอุปกรณ์</h1>
        <p class="text-sm text-slate-500">ตรวจสอบประวัติการสแกนลายนิ้วมือและการยืนยันตัวตนของพนักงานผ่านเครื่อง Kiosk</p>
      </div>
    </div>

    {{-- Filter Form --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
      <form method="GET" action="{{ route('device-scans.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ค้นหา</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="ชื่อพนักงาน / รหัส / ID เครื่อง"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">วันที่เริ่มต้น</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">วันที่สิ้นสุด</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ประเภทการสแกน</label>
            <select name="scan_type"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
              <option value="">ทั้งหมด</option>
              <option value="fingerprint" {{ request('scan_type') == 'fingerprint' ? 'selected' : '' }}>สแกนลายนิ้วมือ (Fingerprint)</option>
              <option value="identification" {{ request('scan_type') == 'identification' ? 'selected' : '' }}>ยืนยันตัวตน (Identification)</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">สถานะ/ผลลัพธ์</label>
            <select name="result"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
              <option value="">ทั้งหมด</option>
              <option value="match" {{ request('result') == 'match' ? 'selected' : '' }}>พบข้อมูลตรงกัน (Match)</option>
              <option value="no_match" {{ request('result') == 'no_match' ? 'selected' : '' }}>ข้อมูลไม่ตรงกัน (No Match)</option>
              <option value="identified" {{ request('result') == 'identified' ? 'selected' : '' }}>ระบุตัวตนสำเร็จ (Identified)</option>
              <option value="fail" {{ request('result') == 'fail' ? 'selected' : '' }}>ล้มเหลว (Fail)</option>
            </select>
          </div>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
          <button type="submit"
            class="px-6 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
            ค้นหา
          </button>

          <a href="{{ route('device-scans.index') }}"
            class="px-6 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition">
            ล้างค่า
          </a>
        </div>
      </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="px-5 py-4 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">รายการประวัติการสแกน</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">#</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">รูปภาพ</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">พนักงาน</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">หน่วยงาน / องค์กร</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">ID เครื่อง</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">ประเภทการสแกน</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">ผลลัพธ์</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">เวลาที่สแกน</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse($scans as $index => $row)
              @php
                $employee = $row->employee;
                $organization = $row->organization;
                
                // Result styling logic
                $isSuccess = in_array($row->result, ['match', 'identified']);
                $isFailed = in_array($row->result, ['no_match', 'fail']);
                
                $resultText = match($row->result) {
                    'match' => 'พบข้อมูลตรงกัน',
                    'no_match' => 'ข้อมูลไม่ตรงกัน',
                    'identified' => 'ระบุตัวตนสำเร็จ',
                    'fail' => 'ล้มเหลว',
                    default => $row->result
                };
                
                $scanTypeText = match($row->scan_type) {
                    'fingerprint' => 'สแกนลายนิ้วมือ',
                    'identification' => 'ระบุตัวตน/บัตร',
                    default => $row->scan_type
                };
              @endphp
              <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 text-slate-500">
                  {{ method_exists($scans, 'firstItem') ? $scans->firstItem() + $index : $index + 1 }}
                </td>

                <td class="px-4 py-3">
                  @if($employee && $employee->image)
                    <img src="{{ asset('storage/' . $employee->image) }}" alt="employee image"
                      class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm">
                  @else
                    <div
                      class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-[10px] font-medium border border-slate-200">
                      {{ $employee ? mb_substr($employee->first_name, 0, 1) . mb_substr($employee->last_name, 0, 1) : '?' }}
                    </div>
                  @endif
                </td>

                <td class="px-4 py-3">
                  <div class="font-medium text-slate-800">
                    {{ $employee ? $employee->first_name . ' ' . $employee->last_name : 'ไม่ทราบชื่อ' }}
                  </div>
                  <div class="text-xs text-slate-500">{{ $employee->emp_id ?? '-' }}</div>
                </td>

                <td class="px-4 py-3 text-slate-600">
                  {{ $organization->name ?? '-' }}
                </td>

                <td class="px-4 py-3">
                  <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded text-slate-600">
                    {{ $row->device_id }}
                  </span>
                </td>

                <td class="px-4 py-3">
                  @if($row->scan_type === 'fingerprint')
                    <span class="inline-flex items-center text-xs text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg font-medium border border-indigo-100">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 11V7a4 4 0 018 0v4c0 .633.088 1.245.253 1.828M8 11a4 4 0 018 0" />
                      </svg>
                      {{ $scanTypeText }}
                    </span>
                  @else
                    <span class="inline-flex items-center text-xs text-sky-700 bg-sky-50 px-2.5 py-1 rounded-lg font-medium border border-sky-100">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 044 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.333 0 4 .667 4 2v1H5v-1c0-1.333 2.667-2 2-2z" />
                      </svg>
                      {{ $scanTypeText }}
                    </span>
                  @endif
                </td>

                <td class="px-4 py-3">
                  @if($isSuccess)
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                      <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-green-500"></span>
                      {{ $resultText }}
                    </span>
                  @elseif($isFailed)
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                      <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-red-500"></span>
                      {{ $resultText }}
                    </span>
                  @else
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                      <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-amber-500"></span>
                      {{ $resultText }}
                    </span>
                  @endif
                </td>

                <td class="px-4 py-3 text-slate-600 whitespace-nowrap">
                  {{ $row->scanned_at ? \Carbon\Carbon::parse($row->scanned_at)->format('d/m/Y H:i:s') : '-' }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="px-4 py-12 text-center">
                  <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-200 mb-3" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-slate-500 text-lg font-medium">ไม่พบข้อมูลประวัติการสแกนอุปกรณ์</p>
                    <p class="text-slate-400 text-sm">ลองเปลี่ยนเงื่อนไขการค้นหาหรืออัปเดตตัวกรอง</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if(method_exists($scans, 'links'))
        <div class="px-5 py-4 border-t border-slate-200 bg-slate-50">
          {{ $scans->links() }}
        </div>
      @endif
    </div>
  </div>
</x-app-layout>
