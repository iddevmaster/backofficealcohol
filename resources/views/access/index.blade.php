<x-app-layout>
<div x-data="accessUi()" x-init="init()" class="space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-semibold">การควบคุมสิทธิ์</h1>
      <p class="text-slate-500">Role & Permissions CRUD · spatie/laravel-permission</p>
    </div>
    <div class="flex items-center gap-2">
      <button @click="openAddRole()" class="rounded bg-blue-600 text-white px-3 py-2">+ New Role</button>
      <button @click="openAddPermission()" class="rounded bg-slate-700 text-white px-3 py-2">+ Add Permission</button>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Roles --}}
    <section class="bg-white rounded-xl shadow">
      <div class="p-4 border-b flex items-center gap-2">
        <h2 class="font-semibold">Roles</h2>
        <form method="get" class="ml-auto flex items-center gap-2">
          <input name="q" value="{{ request('q') }}" placeholder="ค้นหา role" class="rounded border-gray-300 px-2 py-1">
          <select name="guard_name" class="rounded border-gray-300 px-2 py-1">
            <option value="">Guard</option>
            @foreach(($guards ?? ['web','api']) as $g)
              <option value="{{ $g }}" @selected(request('guard_name')===$g)>{{ $g }}</option>
            @endforeach
          </select>
          <input name="org_id" value="{{ request('org_id') }}" placeholder="Org" class="w-24 rounded border-gray-300 px-2 py-1">
          <button class="rounded bg-slate-900 text-white px-3 py-1.5">Search</button>
        </form>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-semibold">ID</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Name</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Guard</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Org</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">#Perms</th>
              <th class="px-4 py-2"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach($roles as $r)
            <tr>
              <td class="px-4 py-2">{{ $r->id }}</td>
              <td class="px-4 py-2">{{ $r->name }}</td>
              <td class="px-4 py-2">{{ $r->guard_name }}</td>
              <td class="px-4 py-2">{{ $r->org_id }}</td>
              <td class="px-4 py-2">{{ $r->permissions_count ?? $r->permissions()->count() }}</td>
              <td class="px-4 py-2 text-right">
                <a href="{{ route('roles.show',$r) }}" class="text-blue-600">ดู</a>
                <a href="{{ route('roles.edit',$r) }}" class="ml-3 text-amber-600">แก้ไข</a>
                <form action="{{ route('roles.destroy',$r) }}" method="post" class="inline" onsubmit="return confirm('ลบ role นี้?')">
                  @csrf @method('DELETE')
                  <button class="ml-3 text-red-600">ลบ</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="p-3">{{ $roles->links() }}</div>
    </section>

    {{-- Permissions --}}
    <section class="bg-white rounded-xl shadow">
      <div class="p-4 border-b flex items-center gap-2">
        <h2 class="font-semibold">Permissions</h2>
        <form method="get" action="{{ route('permissions.index') }}" class="ml-auto flex items-center gap-2">
          <input name="q" value="{{ request('q') }}" placeholder="ค้นหา permission" class="rounded border-gray-300 px-2 py-1">
          <select name="guard_name" class="rounded border-gray-300 px-2 py-1">
            <option value="">Guard</option>
            @foreach(($guards ?? ['web','api']) as $g)
              <option value="{{ $g }}" @selected(request('guard_name')===$g)>{{ $g }}</option>
            @endforeach
          </select>
          <button class="rounded bg-slate-900 text-white px-3 py-1.5">Search</button>
        </form>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-semibold">ID</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Name</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Guard</th>
              <th class="px-4 py-2"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach($permissions as $p)
            <tr>
              <td class="px-4 py-2">{{ $p->id }}</td>
              <td class="px-4 py-2">{{ $p->name }}</td>
              <td class="px-4 py-2">{{ $p->guard_name }}</td>
              <td class="px-4 py-2 text-right">
                <a href="{{ route('permissions.edit',$p) }}" class="text-amber-600">แก้ไข</a>
                <form action="{{ route('permissions.destroy',$p) }}" method="post" class="inline" onsubmit="return confirm('ลบ permission นี้?')">
                  @csrf @method('DELETE')
                  <button class="ml-3 text-red-600">ลบ</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>

  {{-- Modal: Add Role --}}
  <div x-show="showRole" x-cloak class="fixed inset-0 z-40 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30" @click="showRole=false"></div>
    <div class="relative z-50 w-full max-w-3xl bg-white rounded-xl shadow-lg">
      <div class="p-4 border-b flex items-center">
        <h3 class="font-semibold">Add Role</h3>
        <button class="ml-auto text-slate-500 hover:text-slate-800" @click="showRole=false">✕</button>
      </div>
      <form method="post" action="{{ route('roles.store') }}">
        @csrf
        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="space-y-3">
            <div><label class="block text-sm mb-1">Name *</label><input name="name" required class="w-full rounded border-gray-300"/></div>
            <div><label class="block text-sm mb-1">Guard *</label>
              <select name="guard_name" x-model="form.guard" class="w-full rounded border-gray-300">
                @foreach(($guards ?? ['web','api']) as $g)<option value="{{ $g }}">{{ $g }}</option>@endforeach
              </select>
            </div>
            <div><label class="block text-sm mb-1">Org *</label><input type="number" name="org_id" value="1" class="w-full rounded border-gray-300"/></div>
            <div class="pt-2">
              <button type="button" @click="toggleAllPerms(true)" class="text-blue-700 text-sm underline">Check all</button>
              <span class="mx-2 text-slate-400">·</span>
              <button type="button" @click="toggleAllPerms(false)" class="text-slate-700 text-sm underline">Uncheck</button>
            </div>
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm mb-2">Permissions</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-80 overflow-auto p-2 border rounded">
              @foreach($permissions as $p)
                <label class="inline-flex items-center gap-2">
                  <input type="checkbox" name="permissions[]" :checked="form.perms.has({{ $p->id }})"
                         @change="onPermToggle({{ $p->id }}, $event.target.checked)" value="{{ $p->id }}">
                  <span>{{ $p->name }} <span class="text-slate-500 text-xs">({{ $p->guard_name }})</span></span>
                </label>
              @endforeach
            </div>
          </div>
        </div>
        <div class="p-4 border-t flex items-center justify-end gap-2">
          <button type="button" class="rounded px-4 py-2 bg-gray-200" @click="showRole=false">Cancel</button>
          <button class="rounded px-4 py-2 bg-blue-600 text-white">Save</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Add Permission --}}
  <div x-show="showPerm" x-cloak class="fixed inset-0 z-40 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30" @click="showPerm=false"></div>
    <div class="relative z-50 w-full max-w-lg bg-white rounded-xl shadow-lg">
      <div class="p-4 border-b flex items-center">
        <h3 class="font-semibold">Add Permission</h3>
        <button class="ml-auto text-slate-500 hover:text-slate-800" @click="showPerm=false">✕</button>
      </div>
      <form method="post" action="{{ route('permissions.store') }}">
        @csrf
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
          <div><label class="block text-sm mb-1">Name *</label><input name="name" required class="w-full rounded border-gray-300"></div>
          <div><label class="block text-sm mb-1">Guard *</label>
            <select name="guard_name" class="w-full rounded border-gray-300">
              @foreach(($guards ?? ['web','api']) as $g)<option value="{{ $g }}">{{ $g }}</option>@endforeach
            </select>
          </div>
        </div>
        <div class="p-4 border-t flex items-center justify-end gap-2">
          <button type="button" class="rounded px-4 py-2 bg-gray-200" @click="showPerm=false">Cancel</button>
          <button class="rounded px-4 py-2 bg-slate-800 text-white">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function accessUi(){
  return {
    showRole:false, showPerm:false,
    form:{ guard:'web', perms:new Set() },
    allPermIds:@json(($permissions ?? collect())->pluck('id')),
    init(){},
    openAddRole(){ this.showRole=true; }, openAddPermission(){ this.showPerm=true; },
    toggleAllPerms(on){
      this.form.perms = new Set();
      document.querySelectorAll('input[name="permissions[]"]').forEach(cb=>{
        cb.checked = !!on; if(on) this.form.perms.add(parseInt(cb.value));
      });
    },
    onPermToggle(id, checked){ checked?this.form.perms.add(id):this.form.perms.delete(id); },
  }
}
</script>

</x-app-layout>
