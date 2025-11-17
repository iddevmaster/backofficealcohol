<x-app-layout>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Users</h1>
  <a href="{{ route('users.create') }}" class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">+ เพิ่มผู้ใช้</a>
</div>

<form method="get" class="mb-4">
  <div class="flex gap-2">
    <input type="text" name="q" value="{{ $q }}" placeholder="ค้นหา username / ชื่อ / role / org"
           class="flex-1 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
    <button class="rounded-md border px-4 py-2 hover:bg-gray-50">ค้นหา</button>
  </div>
</form>

@if (session('success'))
    <div class="mb-4 rounded-md border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
      {{ session('success') }}
    </div>
@endif

@if($users->count())
  <div class="overflow-x-auto rounded-lg border bg-white">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">username</th>
          <th class="px-4 py-2 text-left">ชื่อ-สกุล</th>
          <th class="px-4 py-2 text-left">role</th>
          <th class="px-4 py-2 text-left">org</th>
          <th class="px-4 py-2 text-left">สถานะ</th>
          <th class="px-4 py-2 text-left">อัปเดต</th>
          <th class="px-4 py-2 text-right">การทำงาน</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @foreach($users as $u)
          <tr>
            <td class="px-4 py-2">{{ $u->id }}</td>
            <td class="px-4 py-2">{{ $u->username }}</td>
            <td class="px-4 py-2">{{ $u->full_name }}</td>
            <td>{{ $u->role->name ?? '-' }}</td>
            <td class="px-4 py-2">{{ $u->organize->name ?? '—' }}</td>
            <td class="px-4 py-2">
              <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs
                {{ $u->status ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                {{ $u->status ? 'ใช้งาน' : 'ปิด' }}
              </span>
            </td>
            <td class="px-4 py-2">{{ $u->updated_at->format('Y-m-d H:i') }}</td>
            <td class="px-4 py-2 text-right">
              <a href="{{ route('users.show', $u) }}" class="inline-flex rounded-md border px-3 py-1.5 hover:bg-gray-50">ดู</a>
              <a href="{{ route('users.edit', $u) }}" class="inline-flex rounded-md border px-3 py-1.5 hover:bg-gray-50">แก้ไข</a>
              <form action="{{ route('users.destroy', $u) }}" method="post" class="inline" onsubmit="return confirm('ลบรายการนี้หรือไม่?');">
                @csrf @method('DELETE')
                <button class="inline-flex rounded-md bg-red-600 px-3 py-1.5 text-white hover:bg-red-700">ลบ</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $users->links() }}</div>
@else
  <div class="rounded-md border bg-white p-6 text-center text-gray-600">ไม่พบข้อมูล</div>
@endif

</x-app-layout>
