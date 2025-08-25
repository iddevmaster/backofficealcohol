@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-medium mb-1">org_id (UUID)</label>
    <input type="text" name="org_id"
           value="{{ old('org_id', $organization->org_id ?? '') }}"
           placeholder="เว้นว่างเพื่อให้ระบบ gen ให้อัตโนมัติ"
           class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('org_id') border-red-500 @enderror">
    @error('org_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">ชื่อองค์กร</label>
    <input type="text" name="name"
           value="{{ old('name', $organization->name ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm font-medium mb-1">โลโก้ (URL/Path)</label>
    <input type="text" name="logo"
           value="{{ old('logo', $organization->logo ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('logo') border-red-500 @enderror">
    @error('logo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="md:col-span-2 flex items-center gap-3">


               <input type="hidden" name="status" value="0">
               <label for="status" class="text-sm">สถานะใช้งาน</label>
<input type="checkbox" name="status" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
       {{ old('status', $organization->status ?? false) ? 'checked' : '' }}>
    
  </div>
</div>


