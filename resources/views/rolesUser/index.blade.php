<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">Roles</h1>
<a href="{{ route('rolesUser.create') }}" class="mb-3 inline-block rounded bg-blue-600 text-white px-3 py-2">+ New</a>
<div class="bg-white rounded-xl shadow overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200">
<thead class="bg-gray-50"><tr>
  <th class="px-4 py-2 text-left text-xs font-semibold">ID</th>
  <th class="px-4 py-2 text-left text-xs font-semibold">Name</th>
  <th class="px-4 py-2 text-left text-xs font-semibold">Guard</th>
  <th class="px-4 py-2 text-left text-xs font-semibold">Org</th>
  <th class="px-4 py-2 text-left text-xs font-semibold">#Perms</th>
  <th class="px-4 py-2"></th></tr></thead>
<tbody class="divide-y divide-gray-100">
@foreach($roles as $r)
<tr>
  <td class="px-4 py-2">{{ $r->id }}</td>
  <td class="px-4 py-2">{{ $r->name }}</td>
  <td class="px-4 py-2">{{ $r->guard_name }}</td>
  <td class="px-4 py-2">{{ $r->org_id }}</td>
  <td class="px-4 py-2">{{ $r->permissions_count ?? $r->permissions()->count() }}</td>
  <td class="px-4 py-2 text-right">
    <a href="{{ route('rolesUser.show',$r) }}" class="text-blue-600">ดู</a>
    <a href="{{ route('rolesUser.edit',$r) }}" class="ml-3 text-amber-600">แก้ไข</a>
    <form action="{{ route('rolesUser.destroy',$r) }}" method="post" class="inline" onsubmit="return confirm('ลบ role นี้?')">
      @csrf @method('DELETE') <button class="ml-3 text-red-600">ลบ</button>
    </form>
  </td>
</tr>
@endforeach
</tbody></table></div>
<div class="mt-4">{{ $roles->links() }}</div>

</x-app-layout>
