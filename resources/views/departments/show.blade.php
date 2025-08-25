<x-app-layout>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">รายละเอียดสาขา</h1>
  <div class="space-x-2">
    <a href="{{ route('branches.edit', $branch) }}" class="inline-flex items-center rounded-md border px-4 py-2 hover:bg-gray-50">แก้ไข</a>
    <a href="{{ route('branches.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a>
  </div>
</div>

<div class="bg-white rounded-lg border p-6">
  <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
    <div><dt class="text-sm text-gray-500">ID</dt><dd class="text-base font-medium">{{ $branch->id }}</dd></div>
    <div><dt class="text-sm text-gray-500">brn_id</dt><dd class="text-base font-medium">{{ $branch->brn_id }}</dd></div>
    <div><dt class="text-sm text-gray-500">name</dt><dd class="text-base font-medium">{{ $branch->name }}</dd></div>
    <div class="sm:col-span-2"><dt class="text-sm text-gray-500">address</dt><dd class="text-base font-medium break-words">{{ $branch->address }}</dd></div>
    <div><dt class="text-sm text-gray-500">tambon_id</dt><dd class="text-base font-medium">{{ $branch->tambon_id }}</dd></div>
    <div><dt class="text-sm text-gray-500">amphur_id</dt><dd class="text-base font-medium">{{ $branch->amphur_id }}</dd></div>
    <div><dt class="text-sm text-gray-500">province_id</dt><dd class="text-base font-medium">{{ $branch->province_id }}</dd></div>
    <div><dt class="text-sm text-gray-500">org_id</dt><dd class="text-base font-medium">{{ $branch->org_id }}</dd></div>
    <div><dt class="text-sm text-gray-500">สร้างเมื่อ</dt><dd class="text-base font-medium">{{ $branch->created_at->format('Y-m-d H:i') }}</dd></div>
    <div><dt class="text-sm text-gray-500">อัปเดตล่าสุด</dt><dd class="text-base font-medium">{{ $branch->updated_at->format('Y-m-d H:i') }}</dd></div>
  </dl>
</div>
</x-app-layout>
