<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">แก้ไขอุปกรณ์ #{{ $deviceslog->id }}</h1>
<form method="post" action="{{ route('deviceslog.update', $deviceslog) }}" class="bg-white rounded-xl shadow p-4 space-y-4">
  @csrf @method('PUT')
  @include('deviceslog._form', ['device'=>$deviceslog])
  <div class="flex gap-2">
    <button class="rounded bg-blue-600 text-white px-4 py-2">บันทึก</button>
    <a href="{{ route('deviceslog.show',$deviceslog) }}" class="rounded bg-gray-200 px-4 py-2">ยกเลิก</a>
  </div>
</form>
</x-app-layout>
