<x-app-layout>

<h1 class="text-2xl font-semibold mb-4">เพิ่ม Log อุปกรณ์</h1>
<form method="post" action="{{ route('deviceslog.store') }}" class="bg-white rounded-xl shadow p-4 space-y-4">
  @csrf
  @include('deviceslog._form')
  <div class="flex gap-2">
    <button class="rounded bg-blue-600 text-white px-4 py-2">บันทึก</button>
    <a href="{{ route('deviceslog.index') }}" class="rounded bg-gray-200 px-4 py-2">ยกเลิก</a>
  </div>
</form>
</x-app-layout>
