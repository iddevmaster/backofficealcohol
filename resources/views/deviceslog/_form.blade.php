@php
  $editing = isset($device);
  $createdVal = old('created_date',
      $editing ? optional($device->created_date)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')
  );
  $lastCalVal = old('last_calibration',
      $editing ? optional($device->last_calibration)->format('Y-m-d') : now()->toDateString()
  );
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">


  <div>
    <label class="block text-sm font-medium mb-1">Serial Number *</label>
    <input type="text" name="serial_num" class="w-full rounded border-gray-300" required
           value="{{ old('serial_num', $device->serial_num ?? '') }}">
    @error('serial_num')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">IP Address</label>
    <input type="text" name="ip_address" class="w-full rounded border-gray-300"
           value="{{ old('ip_address', $device->ip_address ?? '') }}">
    @error('ip_address')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  

  <div>
    <label class="block text-sm font-medium mb-1">Latitude</label>
    <input type="number" step="any" name="latitude" class="w-full rounded border-gray-300"
           value="{{ old('latitude', $device->latitude ?? '') }}">
    @error('latitude')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">Longitude</label>
    <input type="number" step="any" name="longitude" class="w-full rounded border-gray-300"
           value="{{ old('longitude', $device->longitude ?? '') }}">
    @error('longitude')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">Tested Count *</label>
    <input type="number" name="tested_count" class="w-full rounded border-gray-300" min="0" required
           value="{{ old('tested_count', $device->tested_count ?? 0) }}">
    @error('tested_count')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

</div>