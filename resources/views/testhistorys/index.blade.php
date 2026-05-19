<x-app-layout>
  <div class="space-y-6 px-4 py-8 max-w-7xl mx-auto">

    {{-- Page Title --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">ประวัติการทดสอบแอลกอฮอล์</h1>
        <p class="text-sm text-slate-500">จัดการและตรวจสอบประวัติการตรวจวัดแอลกอฮอล์ของพนักงาน</p>
      </div>

      <!-- <div class="flex gap-2">
            <a href="{{ route('histories.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
                + บันทึกผลใหม่
            </a>
            <a href="{{ route('report.alcohol.export', request()->query()) }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition">
                Export Excel
            </a>
        </div> -->
    </div>

    {{-- Filter Form --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
      <form method="GET" action="{{ route('histories.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ค้นหา</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="ชื่อพนักงาน / รหัส / SN"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">วันที่เริ่มต้น</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">วันที่สิ้นสุด</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">สถานะ</label>
            <select name="status"
              class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
              <option value="">ทั้งหมด</option>
              <option value="pass" {{ request('status') == 'pass' ? 'selected' : '' }}>ผ่าน</option>
              <option value="fail" {{ request('status') == 'fail' ? 'selected' : '' }}>ไม่ผ่าน</option>
            </select>
          </div>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
          <button type="submit"
            class="px-6 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
            ค้นหา
          </button>

          <a href="{{ route('histories.index') }}"
            class="px-6 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition">
            ล้างค่า
          </a>
        </div>
      </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="px-5 py-4 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">รายการประวัติการทดสอบ</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">#</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">รูปภาพ</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">พนักงาน</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">SN เครื่อง</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">ระดับแอลกอฮอล์</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">สถานะ</th>
              <th class="px-4 py-3 text-left font-semibold text-slate-600">วันที่ตรวจ</th>
              <th class="px-4 py-3 text-center font-semibold text-slate-600">จัดการ</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse($test as $index => $row)
              @php
                $isPass = $row->alcohol_level <= 0;
                $employee = $row->employee;
              @endphp
              <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 text-slate-500">
                  {{ method_exists($test, 'firstItem') ? $test->firstItem() + $index : $index + 1 }}
                </td>

                <td class="px-4 py-3">
                  @if($row->testing_image)
                    <img src="{{ asset(\Illuminate\Support\Str::startsWith($row->testing_image, 'storage/') ? $row->testing_image : 'storage/' . $row->testing_image) }}" alt="testing image"
                      class="w-12 h-12 rounded-lg object-cover border border-slate-200 shadow-sm">
                  @else
                    <div
                      class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-[10px]">
                      ไม่มีรูป
                    </div>
                  @endif
                </td>

                <td class="px-4 py-3">
                  <div class="font-medium text-slate-800">
                    {{ $employee ? $employee->first_name . ' ' . $employee->last_name : 'ไม่ทราบชื่อ' }}
                  </div>
                  <div class="text-xs text-slate-500">{{ $employee->user_code ?? '-' }}</div>
                </td>

                <td class="px-4 py-3">
                  <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded text-slate-600">
                    {{ $row->device_sn }}
                  </span>
                </td>

                <td class="px-4 py-3">
                  <div class="font-bold {{ $isPass ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($row->alcohol_level, 2) }} mg/L
                  </div>
                </td>

                <td class="px-4 py-3">
                  @if($isPass)
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-green-500"></span>
                      ผ่าน
                    </span>
                  @else
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                      <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-red-500"></span>
                      ไม่ผ่าน
                    </span>
                  @endif
                </td>

                <td class="px-4 py-3 text-slate-600 whitespace-nowrap">
                  {{ $row->testing_date ? \Carbon\Carbon::parse($row->testing_date)->format('d/m/Y H:i') : '-' }}
                </td>

                <td class="px-4 py-3 text-center">
                  <div class="flex justify-center gap-2">
                    <a href="{{ route('histories.edit', $row->id) }}"
                      class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                      title="แก้ไข">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.243 3.243a2.121 2.121 0 013 3L11.707 15.172a4 4 0 01-1.414.949l-3 .75 1.5-4.5a4 4 0 01.949-1.414l7.07-7.071z" />
                      </svg>
                    </a>
                    <form action="{{ route('histories.destroy', $row->id) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="ลบ"
                        onclick="return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </form>
                  </div>
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
                    <p class="text-slate-500 text-lg font-medium">ไม่พบข้อมูลประวัติการทดสอบ</p>
                    <p class="text-slate-400 text-sm">ลองเปลี่ยนเงื่อนไขการค้นหาหรือเพิ่มข้อมูลใหม่</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if(method_exists($test, 'links'))
        <div class="px-5 py-4 border-t border-slate-200 bg-slate-50">
          {{ $test->links() }}
        </div>
      @endif
    </div>
  </div>
</x-app-layout>