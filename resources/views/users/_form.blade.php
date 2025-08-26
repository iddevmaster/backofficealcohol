@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

  <div>
    <label class="block text-sm font-medium mb-1">ชื่อผู้ใช้ (username)</label>
    <input type="text" name="username"
           value="{{ old('username', $user->username ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('username') border-red-500 @enderror">
    @error('username') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">คำนำหน้า (prefix)</label>
    <input type="text" name="prefix"
           value="{{ old('prefix', $user->prefix ?? '') }}"
           placeholder="เช่น Mr., Ms., คุณ"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('prefix') border-red-500 @enderror">
    @error('prefix') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">ชื่อ (first_name)</label>
    <input type="text" name="first_name"
           value="{{ old('first_name', $user->first_name ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
    @error('first_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">นามสกุล (last_name)</label>
    <input type="text" name="last_name"
           value="{{ old('last_name', $user->last_name ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
    @error('last_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">บทบาท (role_id)</label>
    <input type="text" name="role_id"
           value="{{ old('role_id', $user->role_id ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('role_id') border-red-500 @enderror">
    @error('role_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">โทรศัพท์ (phone)</label>
    <input type="text" name="phone"
           value="{{ old('phone', $user->phone ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
    @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">แผนก (dpm_id)</label>
    <input type="text" name="dpm_id"
           value="{{ old('dpm_id', $user->dpm_id ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('dpm_id') border-red-500 @enderror">
    @error('dpm_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">สาขา (brn_id)</label>
    <input type="text" name="brn_id"
           value="{{ old('brn_id', $user->brn_id ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('brn_id') border-red-500 @enderror">
    @error('brn_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">องค์กร (org_id)</label>
    <input type="text" name="org_id"
           value="{{ old('org_id', $user->org_id ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('org_id') border-red-500 @enderror">
    @error('org_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- สถานะ --}}
  <div class="md:col-span-2 flex items-center gap-3 mt-2">
    <input type="hidden" name="status" value="0"> {{-- ต้องอยู่ก่อน checkbox --}}
    <input id="status" type="checkbox" name="status" value="1"
           @checked(old('status', $user->status ?? true))
           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
    <label for="status" class="text-sm">เปิดใช้งาน</label>
  </div>

  {{-- Password (create: required / edit: ใส่เมื่ออยากเปลี่ยน) --}}
  <div class="md:col-span-1">
    <label class="block text-sm font-medium mb-1">
      รหัสผ่าน ({{ request()->routeIs('users.create') ? 'จำเป็น' : 'ไม่กรอก = ไม่เปลี่ยน' }})
    </label>
    <input type="password" name="password"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror">
    @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
  <div class="md:col-span-1">
    <label class="block text-sm font-medium mb-1">ยืนยันรหัสผ่าน</label>
    <input type="password" name="password_confirmation"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
  </div>

</div>