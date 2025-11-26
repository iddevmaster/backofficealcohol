<x-app-layout>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">ฝ่าย</h1>
  <a href="{{ route('departments.create') }}"
     class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
    + เพิ่มฝ่าย
  </a>
</div>

<form method="get" class="mb-4">
  <div class="flex gap-2">
    <input type="text" name="q" placeholder="ค้นหา dpm_id / name / brn_id" value="{{ $q }}"
           class="flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <button class="rounded-md border px-4 py-2 hover:bg-gray-50">ค้นหา</button>
  </div>
</form>


@if (session('success'))
    <div class="mb-4 rounded-md border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
      {{ session('success') }}
    </div>
@endif

@if($departments->count())
  <div class="overflow-x-auto rounded-lg border bg-white">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">รหัสแผนก</th>
          <th class="px-4 py-2 text-left">ชื่อแผนก</th>
          <th class="px-4 py-2 text-left">รหัสสาขา</th>
           <th class="px-4 py-2 text-left">ชื่อสาขา</th>
          <th class="px-4 py-2 text-left">อัปเดตล่าสุด</th>
          <th class="px-4 py-2 text-right">การทำงาน</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @foreach($departments as $dep)
          <tr>
            <td class="px-4 py-2">{{ $dep->id }}</td>
            <td class="px-4 py-2">
              <a href="{{ route('departments.show', $dep) }}" class="text-indigo-600 hover:underline">
                {{ $dep->dpm_id }}
              </a>
            </td>
            <td class="px-4 py-2">{{ $dep->name }}</td>
             <td class="px-4 py-2" >
           

              @if($dep->branches)   
                 {{ $dep->branches->brn_id }}      
@else
 - 
@endif
            </td>
            <td class="px-4 py-2">

              @if($dep->branches)   
                 {{ $dep->branches->name }}      
@else
 - 
@endif

            </td>
            <td class="px-4 py-2">{{ $dep->updated_at->format('Y-m-d H:i') }}</td>
            <td class="px-4 py-2 text-right">
              <a href="{{ route('departments.edit', $dep) }}"
                 class="inline-flex items-center rounded-md border px-3 py-1.5 hover:bg-gray-50">แก้ไข</a>
              <form action="{{ route('departments.destroy', $dep) }}" method="post" class="inline"
                    onsubmit="return confirm('ลบรายการนี้หรือไม่?');">
                @csrf @method('DELETE')
                <button class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-white hover:bg-red-700">
                  ลบ
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{-- Laravel ใช้ Tailwind เป็นค่าเริ่มต้นของ paginator อยู่แล้ว --}}
    {{ $departments->links() }}
  </div>
@else
  <div class="rounded-md border bg-white p-6 text-center text-gray-600">
    ไม่พบข้อมูล
  </div>
@endif
</x-app-layout>
