<x-app-layout>
<div class="bg-white rounded-lg border p-6 max-w-3xl mx-auto">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">รายละเอียดองค์กร</h1>
    <div class="space-x-2">
      <a href="{{ route('organizations.edit',$organization) }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">แก้ไข</a>
      <a href="{{ route('organizations.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a>
    </div>
  </div>
  <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><dt class="text-sm text-gray-500">org_id</dt><dd class="font-medium break-words">{{ $organization->org_id }}</dd></div>
    <div><dt class="text-sm text-gray-500">ชื่อ</dt><dd class="font-medium">{{ $organization->name }}</dd></div>
    <div class="md:col-span-2"><dt class="text-sm text-gray-500">โลโก้</dt>
      <dd class="font-medium break-words">
        @if($organization->logo)
          <img src="{{ $organization->logo }}" alt="logo" class="h-12">
          <div class="text-xs text-gray-500 mt-1">{{ $organization->logo }}</div>
        @else
          —
        @endif
      </dd>
    </div>
    <div><dt class="text-sm text-gray-500">สถานะ</dt><dd class="font-medium">{{ $organization->status ? 'ใช้งาน' : 'ปิด' }}</dd></div>
    <div><dt class="text-sm text-gray-500">อัปเดตล่าสุด</dt><dd class="font-medium">{{ $organization->updated_at->format('Y-m-d H:i') }}</dd></div>
  </dl>
</div>
</x-app-layout>
