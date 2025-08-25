<x-app-layout>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Prefixes</h1>
  <a href="{{ route('prefixes.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">+ เพิ่ม</a>
</div>

<form method="get" class="mb-4">
  <div class="flex gap-2">
    <input type="text" name="q" value="{{ $q }}" placeholder="ค้นหาคำนำหน้า"
           class="flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <button class="rounded-md border px-4 py-2 hover:bg-gray-50">ค้นหา</button>
  </div>
</form>

@if($prefixes->count())
  <div class="overflow-x-auto rounded-lg border bg-white">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">ชื่อ</th>
          <th class="px-4 py-2 text-left">อัปเดตล่าสุด</th>
          <th class="px-4 py-2 text-right">การทำงาน</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @foreach($prefixes as $p)
          <tr>
            <td class="px-4 py-2">{{ $p->id }}</td>
            <td class="px-4 py-2">{{ $p->name }}</td>
            <td class="px-4 py-2">{{ $p->updated_at->format('Y-m-d H:i') }}</td>
            <td class="px-4 py-2 text-right">
              <a href="{{ route('prefixes.show', $p) }}" class="inline-flex rounded-md border px-3 py-1.5 hover:bg-gray-50">ดู</a>
              <a href="{{ route('prefixes.edit', $p) }}" class="inline-flex rounded-md border px-3 py-1.5 hover:bg-gray-50">แก้ไข</a>
              <form action="{{ route('prefixes.destroy', $p) }}" method="post" class="inline" onsubmit="return confirm('ลบรายการนี้หรือไม่?');">
                @csrf @method('DELETE')
                <button class="inline-flex rounded-md bg-red-600 px-3 py-1.5 text-white hover:bg-red-700">ลบ</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $prefixes->links() }}</div>
@else
  <div class="rounded-md border bg-white p-6 text-center text-gray-600">ไม่พบข้อมูล</div>
@endif

</x-app-layout>
