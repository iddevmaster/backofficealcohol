@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-medium mb-1">รหัสสาขา (brn_id)</label>
    <input type="text" name="brn_id"
      class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('brn_id') border-red-500 @enderror"
      value="{{ old('brn_id', $branch->brn_id) }}">
    @error('brn_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">ชื่อสาขา (name)</label>
    <input type="text" name="name"
      class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
      value="{{ old('name', $branch->name) }}">
    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm font-medium mb-1">ที่อยู่ (address)</label>
    <input type="text" name="address"
      class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('address') border-red-500 @enderror"
      value="{{ old('address', $branch->address) }}">
    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
  </div>

  <!-- <div>
    <label class="block text-sm font-medium mb-1">ตำบล (tambon_id)</label>
    <input type="number" name="tambon_id"
      class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('tambon_id') border-red-500 @enderror"
      value="{{ old('tambon_id', $branch->tambon_id) }}">
    @error('tambon_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">อำเภอ (amphur_id)</label>
    <input type="number" name="amphur_id"
      class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('amphur_id') border-red-500 @enderror"
      value="{{ old('amphur_id', $branch->amphur_id) }}">
    @error('amphur_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">จังหวัด (province_id)</label>
    <input type="number" name="province_id"
      class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('province_id') border-red-500 @enderror"
      value="{{ old('province_id', $branch->province_id) }}">
    @error('province_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
  </div> -->

  <div>
    <label class="block text-sm font-medium mb-1">รหัสองค์กร (org_id)</label>
    <input type="text" name="org_id"
      class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('org_id') border-red-500 @enderror"
      value="{{ old('org_id', $branch->org_id) }}">
    @error('org_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
  </div>
</div>

<div class="mt-4">
  @include('forms._location', [
    'provinces' => $provinces,
    'values'    => $values ?? ['province_id'=>null,'amphur_id'=>null,'tambon_id'=>null],
  ])
</div>

