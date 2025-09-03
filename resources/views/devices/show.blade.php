<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">Device #{{ $device->id }}</h1>
<div class="bg-white rounded-xl shadow p-4 space-y-2">
  <div><b>Model:</b> {{ $device->model }}</div>
  <div><b>Serial:</b> {{ $device->serial_num }}</div>
  <div><b>IP:</b> {{ $device->ip_address ?? '-' }}</div>
  <div><b>Sensor SN:</b> {{ $device->sensor_sn ?? '-' }}</div>
  <div><b>Sensor Body SN:</b> {{ $device->sensor_body_sn ?? '-' }}</div>
  <div><b>Pi MAC:</b> {{ $device->pi_mac_address ?? '-' }}</div>
  <div><b>Created:</b> {{ $device->created_date?->format('Y-m-d H:i') }}</div>
  <div><b>Latitude:</b> {{ $device->latitude ?? '-' }}</div>
  <div><b>Longitude:</b> {{ $device->longitude ?? '-' }}</div>
  <div><b>Tested Count:</b> {{ $device->tested_count }}</div>
  <div><b>Last Calibration:</b> {{ $device->last_calibration?->format('Y-m-d') }}</div>
  <div><b>Status:</b> {{ $device->status }}</div>

  <div class="pt-3">
    <a href="{{ route('devices.edit',$device) }}" class="rounded bg-amber-500 text-white px-4 py-2">แก้ไข</a>
    <a href="{{ route('devices.index') }}" class="rounded bg-gray-200 px-4 py-2">กลับ</a>
  </div>
</div>
</x-app-layout>
