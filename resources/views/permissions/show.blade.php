<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">Permission #{{ $permission->id }}</h1>
<div class="bg-white rounded-xl shadow p-4 space-y-2">
  <div><b>Name:</b> {{ $permission->name }}</div>
  <div><b>Guard:</b> {{ $permission->guard_name }}</div>
  <div class="pt-3">
    <a href="{{ route('permissions.edit',$permission) }}" class="rounded bg-amber-500 text-white px-4 py-2">แก้ไข</a>
    <a href="{{ route('permissions.index') }}" class="rounded bg-gray-200 px-4 py-2">กลับ</a>
  </div>
</div>
</x-app-layout>
