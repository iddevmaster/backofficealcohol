<x-app-layout>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">อุปกรณ์</h1>
  <a href="{{ route('deviceslog.create') }}"
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

@if (session('success'))
    <div class="mb-4 rounded-md border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
      {{ session('success') }}
    </div>
@endif

@if($deviceslog->count())
  <div class="overflow-x-auto rounded-lg border bg-white">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
        <th class="px-4 py-2 text-left text-xs font-semibold">#</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">serial_num</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">ip_address</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">latitude</th>
        <th class="px-4 py-2 text-left text-xs font-semibold">longitude</th>
    
        <th class="px-4 py-2"></th>
      </tr>
      </thead>
      <tbody class="divide-y">
 @foreach($deviceslog as $d)
        <tr>
          <td class="px-4 py-2">{{ $d->id }}</td>
            <td class="px-4 py-2">{{ $d->serial_num }}</td>
     
          <td class="px-4 py-2">{{ $d->ip_address ?? '-' }}</td>
           <td class="px-4 py-2">{{ $d->latitude ?? '-' }}</td>
            <td class="px-4 py-2">{{ $d->longitude ?? '-' }}</td>

         <td class="px-4 py-2 text-right">
  <a href="{{ route('deviceslog.show',$d) }}" class="text-blue-600">ดู</a>
  <a href="{{ route('deviceslog.edit',$d) }}" class="ml-3 text-amber-600">แก้ไข</a>


 <form action="{{ route('deviceslog.destroy',$d) }}" method="post" class="inline" onsubmit="return confirm('ลบอุปกรณ์นี้?')">
            @csrf @method('DELETE')
            <button class="ml-3 text-red-600">ลบ</button>
          </form>
</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>



<div class="mt-4">{{ $deviceslog->links() }}</div>
@else
  <div class="rounded-md border bg-white p-6 text-center text-gray-600">
    ไม่พบข้อมูล
  </div>
@endif

</x-app-layout>
