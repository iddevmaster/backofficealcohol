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


  <div>
    <label class="block text-sm font-medium mb-1">รหัสสาขา (brn_id) *</label>
    <select name="brn_id" class="w-full rounded border-gray-300" required>
      <option value="">-- เลือกสาขา --</option>
      @foreach(($branches ?? []) as $b)
        <option value="{{ $b->id }}" @selected(old('brn_id', $department->brn_id ?? '') == $b->id)>
          {{ $b->name }} ({{ $b->id }})
        </option>
      @endforeach
    </select>
    @error('brn_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>


