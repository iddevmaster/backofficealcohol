@csrf
<div class="mb-4">
  <label class="block text-sm font-medium mb-1">รหัสแผนก (dpm_id)</label>
  <input type="text" name="dpm_id"
         class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('dpm_id') border-red-500 @enderror"
         value="{{ old('dpm_id', $department->dpm_id) }}" required>
  @error('dpm_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
  <label class="block text-sm font-medium mb-1">ชื่อแผนก (name)</label>
  <input type="text" name="name"
         class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
         value="{{ old('name', $department->name) }}" required>
  @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-6">
  <label class="block text-sm font-medium mb-1">รหัสสาขา (brn_id)</label>
  <input type="text" name="brn_id"
         class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('brn_id') border-red-500 @enderror"
         value="{{ old('brn_id', $department->brn_id) }}" required>
  @error('brn_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="flex items-center gap-3">
  <button type="submit"
          class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
    บันทึก
  </button>
  <a href="{{ route('departments.index') }}"
     class="inline-flex items-center rounded-md border px-4 py-2 hover:bg-gray-50">
    ยกเลิก
  </a>
</div>
