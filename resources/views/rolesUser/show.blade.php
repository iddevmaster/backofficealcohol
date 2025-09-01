<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">Role #{{ $role->id }}</h1>
<div class="bg-white rounded-xl shadow p-4 space-y-2">
  <div><b>Name:</b> {{ $role->name }}</div>
  <div><b>Guard:</b> {{ $role->guard_name }}</div>
  <div><b>Org:</b> {{ $role->org_id }}</div>
  <div class="pt-2">
    <b>Permissions ({{ $role->permissions->count() }}):</b>
    <ul class="list-disc pl-6">
      @foreach($role->permissions as $p)
        <li>{{ $p->name }} ({{ $p->guard_name }})</li>
      @endforeach
    </ul>
  </div>
  <div class="pt-3">
    <a href="{{ route('rolesUser.index') }}" class="rounded bg-gray-200 px-4 py-2">กลับ</a>
  </div>
</div>
</x-app-layout>
