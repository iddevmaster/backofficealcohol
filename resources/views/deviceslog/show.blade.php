<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">Device #{{ $deviceslog->id }}</h1>
<div class="bg-white rounded-xl shadow p-4 space-y-2">
  <div><b>Serial:</b> {{ $deviceslog->serial_num }}</div>
  <div><b>IP:</b> {{ $deviceslog->ip_address ?? '-' }}</div>

  <div><b>Created:</b> {{ $deviceslog->created_at?->format('Y-m-d H:i') }}</div>
  <div><b>Latitude:</b> {{ $deviceslog->latitude ?? '-' }}</div>
  <div><b>Longitude:</b> {{ $deviceslog->longitude ?? '-' }}</div>
  <div><b>Tested Count:</b> {{ $deviceslog->tested_count }}</div>


  <div class="pt-3">
    <a href="{{ route('deviceslog.edit',$deviceslog) }}" class="rounded bg-amber-500 text-white px-4 py-2">แก้ไข</a>
    <a href="{{ route('deviceslog.index') }}" class="rounded bg-gray-200 px-4 py-2">กลับ</a>
  </div>
</div>
</x-app-layout>
