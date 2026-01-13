<x-app-layout>
<div class="bg-white rounded-lg border p-6 max-w-3xl mx-auto">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">รายละเอียดผู้ใช้</h1>
    <div class="space-x-2">
      <a href="{{ route('users.edit',$user) }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">แก้ไข</a>
      <a href="{{ route('users.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a>
    </div>
  </div>
  <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><dt class="text-sm text-gray-500">username</dt><dd class="font-medium break-words">{{ $user->username }}</dd></div>
    <div><dt class="text-sm text-gray-500">คำนำหน้า</dt><dd class="font-medium">{{ $user->prefix }}</dd></div>
    <div><dt class="text-sm text-gray-500">ชื่อ</dt><dd class="font-medium">{{ $user->first_name }}</dd></div>
    <div><dt class="text-sm text-gray-500">นามสกุล</dt><dd class="font-medium">{{ $user->last_name }}</dd></div>
    <div><dt class="text-sm text-gray-500">บทบาท</dt><dd class="font-medium">{{ $user->role_id }}</dd></div>
    <div><dt class="text-sm text-gray-500">โทรศัพท์</dt><dd class="font-medium">{{ $user->phone ?? '—' }}</dd></div>
    <div><dt class="text-sm text-gray-500">แผนก</dt><dd class="font-medium">{{ $user->dpm_id ?? '—' }}</dd></div>
    <div><dt class="text-sm text-gray-500">สาขา</dt><dd class="font-medium">{{ $user->brn_id ?? '—' }}</dd></div>
    <div><dt class="text-sm text-gray-500">องค์กร</dt><dd class="font-medium">{{ $user->org_id ?? '—' }}</dd></div>
    <div><dt class="text-sm text-gray-500">สถานะ</dt><dd class="font-medium">{{ $user->status ? 'ใช้งาน' : 'ปิด' }}</dd></div>
    <div><dt class="text-sm text-gray-500">อัปเดตล่าสุด</dt><dd class="font-medium">{{ $user->updated_at->format('Y-m-d H:i') }}</dd></div>
  </dl>
</div>
</x-app-layout>
