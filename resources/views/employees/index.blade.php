<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">พนักงาน</h1>

<form method="get" class="mb-4">
  <div class="flex gap-2">
    <select name="org_id" class="rounded border-gray-300">
      <option value="">-- ทุกองค์กร --</option>
      @foreach($organizations as $o)
        <option value="{{ $o->id }}" @selected(request('org_id')==$o->id)>{{ $o->name }}</option>
      @endforeach
    </select>

    <input type="text" name="q" placeholder="ค้นหา emp_id / ชื่อ / โทร"
           value="{{ $q }}" class="flex-1 rounded border-gray-300 px-2">
    <button class="rounded bg-slate-900 text-white px-3">ค้นหา</button>

    <a href="{{ route('employees.create') }}" class="ml-auto rounded bg-blue-600 text-white px-3 py-2">+ เพิ่มพนักงาน</a>
  </div>
</form>

@if($employees->count())
<div class="overflow-x-auto rounded-lg border bg-white">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="px-4 py-2 text-left text-xs font-semibold">#</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">EMP ID</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">ชื่อ-สกุล</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">องค์กร</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">สาขา</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">แผนก</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">สถานะ</th>
        <th class="px-4 py-2"></th>
      </tr>
    </thead>
    <tbody class="divide-y">
      @foreach($employees as $e)
      <tr>
        <td class="px-4 py-2">{{ $e->id }}</td>
        <td class="px-4 py-2">{{ $e->emp_id }}</td>
        <td class="px-4 py-2">
          <div class="flex items-center gap-2">
            @if($e->image_url)
              <img src="{{ $e->image_url }}" class="h-8 w-8 rounded-full object-cover" alt="">
            @endif
            <span>{{ $e->full_name }}</span>
          </div>
        </td>
        <td class="px-4 py-2">{{ $e->organization->name ?? '-' }}</td>
        <td class="px-4 py-2">{{ $e->branch->name ?? '-' }}</td>
        <td class="px-4 py-2">{{ $e->department->name ?? '-' }}</td>
        <td class="px-4 py-2">
          @if($e->status)
            <span class="rounded bg-emerald-100 text-emerald-800 px-2 py-0.5 text-xs">Active</span>
          @else
            <span class="rounded bg-gray-200 text-gray-700 px-2 py-0.5 text-xs">Inactive</span>
          @endif
        </td>
        <td class="px-4 py-2 text-right">
          <a href="{{ route('employees.show',$e) }}" class="text-blue-600">ดู</a>
          <a href="{{ route('employees.edit',$e) }}" class="ml-3 text-amber-600">แก้ไข</a>
                  <form action="{{ route('employees.destroy',$e) }}" method="post" class="inline" onsubmit="return confirm('ลบอุปกรณ์นี้?')">
            @csrf @method('DELETE')
            <button class="ml-3 text-red-600">ลบ</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $employees->links() }}</div>
@else
  <div class="rounded-md border bg-white p-6 text-center text-gray-600">ไม่พบข้อมูล</div>
@endif

<!-- {{-- Delete Modal (teleport เพื่อไม่โดนครอป) --}}
<div x-data="{show:false,url:'',label:'',
              open(d){this.url=d.url;this.label=d.label||'';this.show=true},
              close(){this.show=false;this.url='';this.label=''} }"
     x-on:open-delete.window="open($event.detail)" x-cloak>
  <template x-teleport="body">
    <div x-show="show" class="fixed inset-0 z-50" x-on:keydown.escape.window="close()">
      <div class="absolute inset-0 bg-black/50" @click="close()" x-transition.opacity></div>
      <div class="relative mx-auto mt-40 w-full max-w-md">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden" x-transition.scale.origin.top role="dialog">
          <div class="p-4 border-b"><h3 class="text-lg font-semibold">ยืนยันการลบ</h3></div>
          <form :action="url" method="POST" class="p-4 space-y-4">
            @csrf @method('DELETE')
            <p class="text-slate-700">ต้องการลบ <span class="font-medium" x-text="label"></span> ใช่ไหม?</p>
            <div class="flex justify-end gap-2">
              <button type="button" class="rounded bg-gray-200 px-4 py-2" @click="close()">ยกเลิก</button>
              <button type="submit" class="rounded bg-red-600 text-white px-4 py-2">ลบ</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
</div> -->


</x-app-layout>
