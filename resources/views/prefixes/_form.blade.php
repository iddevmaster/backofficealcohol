@csrf
<div class="grid grid-cols-1 gap-4">
  <div>
    <label class="block text-sm font-medium mb-1">คำนำหน้า (name)</label>
    <input type="text" name="name"
           value="{{ old('name', $prefix->name ?? '') }}"
           placeholder="เช่น Mr., Mrs., Dr., คุณ, นาง, น.ส."
           class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
</div>
