<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">แก้ไขอุปกรณ์ #{{ $device->id }}</h1>
<form method="post" action="{{ route('devices.update', $device) }}" class="bg-white rounded-xl shadow p-4 space-y-4">
  @csrf @method('PUT')
  @include('devices._form', ['device'=>$device])
  <div class="flex gap-2">
    <button class="rounded bg-blue-600 text-white px-4 py-2">บันทึก</button>
    <a href="{{ route('devices.show',$device) }}" class="rounded bg-gray-200 px-4 py-2">ยกเลิก</a>
  </div>
</form>
</x-app-layout>
