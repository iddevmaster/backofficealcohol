<x-app-layout>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Organizations</h1>
  <a href="{{ route('organizations.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">+ เพิ่มองค์กร</a>
</div>

<form method="get" class="mb-4">
  <div class="flex gap-2">
    <input type="text" name="q" value="{{ $q }}" placeholder="ค้นหา org_id / name"
           class="flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <button class="rounded-md border px-4 py-2 hover:bg-gray-50">ค้นหา</button>
  </div>
</form>

@if($orgs->count())
  <div class="overflow-x-auto rounded-lg border bg-white">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">รหัสอง์กร</th>
          <th class="px-4 py-2 text-left">ชื่อ</th>
          <th class="px-4 py-2 text-left">สถานะ</th>
          <th class="px-4 py-2 text-left">อัปเดตล่าสุด</th>
          <th class="px-4 py-2 text-right">การทำงาน</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @foreach($orgs as $o)
          <tr>
            <td class="px-4 py-2">{{ $o->id }}</td>
            <td class="px-4 py-2">{{ $o->org_id }}</td>
            <td class="px-4 py-2">{{ $o->name }}</td>
            <td class="px-4 py-2">
              <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs
                {{ $o->status ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                {{ $o->status ? 'ใช้งาน' : 'ปิด' }}
              </span>
            </td>
            <td class="px-4 py-2">{{ $o->updated_at->format('Y-m-d H:i') }}</td>
            <td class="px-4 py-2 text-right">
              <a href="{{ route('organizations.show', $o) }}" class="inline-flex rounded-md border px-3 py-1.5 hover:bg-gray-50">ดู</a>
              <a href="{{ route('organizations.edit', $o) }}" class="inline-flex rounded-md border px-3 py-1.5 hover:bg-gray-50">แก้ไข</a>
              <form action="{{ route('organizations.destroy', $o) }}" method="post" class="inline" onsubmit="return confirm('ลบรายการนี้หรือไม่?');">
                @csrf @method('DELETE')
                <button class="inline-flex rounded-md bg-red-600 px-3 py-1.5 text-white hover:bg-red-700">ลบ</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $orgs->links() }}</div>
@else
  <div class="rounded-md border bg-white p-6 text-center text-gray-600">ไม่พบข้อมูล</div>
@endif

</x-app-layout>
