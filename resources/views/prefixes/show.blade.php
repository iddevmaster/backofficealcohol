<x-app-layout>
<div class="bg-white rounded-lg border p-6 max-w-lg mx-auto">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">รายละเอียดคำนำหน้า</h1>
    <div class="space-x-2">
      <a href="{{ route('prefixes.edit',$prefix) }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">แก้ไข</a>
      <a href="{{ route('prefixes.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a>
    </div>
  </div>
  <dl class="grid grid-cols-1 gap-4">
    <div>
      <dt class="text-sm text-gray-500">ชื่อ</dt>
      <dd class="font-medium">{{ $prefix->name }}</dd>
    </div>
    <div>
      <dt class="text-sm text-gray-500">อัปเดตล่าสุด</dt>
      <dd class="font-medium">{{ $prefix->updated_at->format('Y-m-d H:i') }}</dd>
    </div>
  </dl>
</div>
</x-app-layout>
