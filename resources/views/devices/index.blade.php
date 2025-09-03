<x-app-layout>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">อุปกรณ์</h1>
  <a href="{{ route('departments.create') }}"
     class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
    + อุปกรณ์
  </a>
</div>

<form method="get" class="mb-4">
  <div class="flex gap-2">
    <input type="text" name="q" placeholder="ค้นหา อุปกรณ์" value="{{ $q }}"
           class="flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <button class="rounded-md border px-4 py-2 hover:bg-gray-50">ค้นหา</button>
  </div>
</form>

@if($devices->count())
  <div class="overflow-x-auto rounded-lg border bg-white">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
        <th class="px-4 py-2 text-left text-xs font-semibold">#</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">Model</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">Serial</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">IP</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">Created</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">Status</th>
        <th class="px-4 py-2"></th>
      </tr>
      </thead>
      <tbody class="divide-y">
 @foreach($devices as $d)
        <tr>
          <td class="px-4 py-2">{{ $d->id }}</td>
          <td class="px-4 py-2">{{ $d->model }}</td>
          <td class="px-4 py-2">{{ $d->serial_num }}</td>
          <td class="px-4 py-2">{{ $d->ip_address ?? '-' }}</td>
          <td class="px-4 py-2">{{ $d->created_date?->format('Y-m-d H:i') }}</td>
          <td class="px-4 py-2">{{ $d->status }}</td>
         <td class="px-4 py-2 text-right">
  <a href="{{ route('devices.show',$d) }}" class="text-blue-600">ดู</a>
  <a href="{{ route('devices.edit',$d) }}" class="ml-3 text-amber-600">แก้ไข</a>

  {{-- ปุ่มเปิดโมดัลยืนยันลบ --}}
  <button type="button"
          class="ml-3 text-red-600 hover:underline"
          @click="$dispatch('open-delete', {
              url: @js(route('devices.destroy',$d)),
              label: @js($d->serial_num) 
          })">
    ลบ
  </button>
</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>



<div class="mt-4">{{ $devices->links() }}</div>
@else
  <div class="rounded-md border bg-white p-6 text-center text-gray-600">
    ไม่พบข้อมูล
  </div>
@endif

<div
  x-data="{
    show:false, url:'', label:'',
    open(detail){ this.url = detail.url; this.label = detail.label ?? ''; this.show = true },
    close(){ this.show = false; this.url=''; this.label='' }
  }"
  x-on:open-delete.window="open($event.detail)"
  x-cloak
>
  <div x-show="show" class="fixed inset-0 z-50" x-on:keydown.escape.window="close()">
    <div class="absolute inset-0 bg-black/50" @click="close()" x-transition.opacity></div>

    <div class="relative mx-auto mt-40 w-full max-w-md">
      <div class="bg-white rounded-xl shadow-xl overflow-hidden" role="dialog" aria-modal="true"
           x-transition.scale.origin.top>
        <div class="p-4 border-b">
          <h3 class="text-lg font-semibold">ยืนยันการลบ</h3>
        </div>

        <form :action="url" method="POST" class="p-4 space-y-4">
          @csrf
          @method('DELETE')

          <p class="text-slate-700">
            ต้องการลบอุปกรณ์ <span class="font-medium" x-text="label"></span> ใช่ไหม?
          </p>

          <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="rounded bg-gray-200 px-4 py-2" @click="close()">ยกเลิก</button>
            <button type="submit" class="rounded bg-red-600 text-white px-4 py-2">ลบ</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</x-app-layout>
