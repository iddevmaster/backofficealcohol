<x-app-layout>
  <style>[x-cloak] { display: none !important; }</style>
  <div x-data="accessUi()" class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold">การควบคุมสิทธิ์</h1>
        <p class="text-slate-500">Role & Permissions</p>
      </div>
      <div class="flex items-center gap-2">
        <button @click="openAddRole()" class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700 transition font-medium">+ New Role</button>
        <button @click="openAddPermission()" class="rounded bg-slate-700 text-white px-4 py-2 hover:bg-slate-800 transition font-medium">+ Add Permission</button>
      </div>
    </div>

    @if (session('success'))
      <div class="mb-4 rounded-md border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('success') }}
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      {{-- Roles --}}
      <section class="bg-white rounded-xl shadow border">
        <div class="p-4 border-b flex items-center gap-2">
          <h2 class="font-semibold text-lg text-gray-900">Roles</h2>
          <form method="get" class="ml-auto flex items-center gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="ค้นหา role"
              class="rounded border-gray-300 px-2 py-1 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            <button class="rounded bg-slate-900 text-white px-3 py-1.5 hover:bg-slate-850 transition text-sm font-medium">Search</button>
          </form>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-semibold">ID</th>
                <th class="px-4 py-2 text-left text-xs font-semibold">Name</th>
                <th class="px-4 py-2 text-left text-xs font-semibold">Guard</th>
                <th class="px-4 py-2"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-800">
              @foreach($roles as $r)
                <tr>
                  <td class="px-4 py-2">{{ $r->id }}</td>
                  <td class="px-4 py-2 font-medium">{{ $r->name }}</td>
                  <td class="px-4 py-2 text-gray-500">{{ $r->guard_name }}</td>
                  <td class="px-4 py-2 text-right whitespace-nowrap">
                    <a href="{{ route('admin.roles.show', $r) }}" class="text-blue-600 hover:text-blue-850 font-medium">ดู</a>
                    <a href="{{ route('admin.roles.edit', $r) }}" class="ml-3 text-amber-600 hover:text-amber-800 font-medium">แก้ไข</a>
                    <form action="{{ route('admin.roles.destroy', $r) }}" method="post" class="inline"
                      onsubmit="return confirm('ลบ role นี้?')">
                      @csrf @method('DELETE')
                      <button class="ml-3 text-red-600 hover:text-red-800 font-medium">ลบ</button>
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
      <section class="bg-white rounded-xl shadow border">
        <div class="p-4 border-b flex items-center gap-2">
          <h2 class="font-semibold text-lg text-gray-900">Permissions</h2>
          <form method="get" action="{{ route('permissions.index') }}" class="ml-auto flex items-center gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="ค้นหา permission"
              class="rounded border-gray-300 px-2 py-1 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            <select name="guard_name" class="rounded border-gray-300 px-2 py-1 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
              <option value="">Guard</option>
              @foreach(($guards ?? ['web', 'api']) as $g)
                <option value="{{ $g }}" @selected(request('guard_name') === $g)>{{ $g }}</option>
              @endforeach
            </select>
            <button class="rounded bg-slate-900 text-white px-3 py-1.5 hover:bg-slate-850 transition text-sm font-medium">Search</button>
          </form>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-semibold">ID</th>
                <th class="px-4 py-2 text-left text-xs font-semibold">Name</th>
                <th class="px-4 py-2"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-800">
              @foreach($permissions as $p)
                <tr>
                  <td class="px-4 py-2">{{ $p->id }}</td>
                  <td class="px-4 py-2 font-medium">{{ $p->name }}</td>
                  <td class="px-4 py-2 text-right whitespace-nowrap">
                    <a href="{{ route('permissions.edit', $p) }}" class="text-amber-600 hover:text-amber-850 font-medium">แก้ไข</a>
                    <form action="{{ route('permissions.destroy', $p) }}" method="post" class="inline"
                      onsubmit="return confirm('ลบ permission นี้?')">
                      @csrf @method('DELETE')
                      <button class="ml-3 text-red-600 hover:text-red-800 font-medium">ลบ</button>
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
    <template x-teleport="body">
      <div x-show="showRole" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center" style="display: none;">
        <!-- Backdrop overlay -->
        <div class="fixed inset-0" @click="showRole=false"></div>

        <div class="relative z-50 w-full max-w-3xl bg-white rounded-xl shadow-lg border transform transition-all my-8">
          <div class="p-4 border-b flex items-center justify-between bg-gray-50 rounded-t-xl">
            <h3 class="font-semibold text-lg text-gray-900">Add Role</h3>
            <button class="text-gray-400 hover:text-gray-600" @click="showRole=false">✕</button>
          </div>
          <form method="post" action="{{ route('admin.roles.store') }}">
            @csrf
            <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="space-y-3">
                <div>
                  <label class="block text-sm mb-1 font-medium text-gray-700">Name *</label>
                  <input name="name" required class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div>
                  <label class="block text-sm mb-1 font-medium text-gray-700">Guard *</label>
                  <select name="guard_name" x-model="form.guard" class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach(($guards ?? ['web', 'api']) as $g)
                      <option value="{{ $g }}">{{ $g }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="pt-2">
                  <button type="button" @click="toggleAllPerms(true)" class="text-blue-650 hover:text-blue-800 text-sm font-medium underline">Check all</button>
                  <span class="mx-2 text-slate-400">·</span>
                  <button type="button" @click="toggleAllPerms(false)" class="text-slate-650 hover:text-slate-800 text-sm font-medium underline">Uncheck</button>
                </div>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm mb-2 font-medium text-gray-700">Permissions</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-80 overflow-auto p-2 border rounded bg-gray-50">
                  @foreach($permissions as $p)
                    <label class="inline-flex items-center gap-2 cursor-pointer p-1 hover:bg-white rounded transition text-sm">
                      <input type="checkbox" name="permissions[]" :checked="!!form.perms[{{ $p->id }}]"
                        @change="form.perms[{{ $p->id }}] = $event.target.checked" value="{{ $p->id }}"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                      <span>{{ $p->name }} <span class="text-slate-400 text-xs">({{ $p->guard_name }})</span></span>
                    </label>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="p-4 border-t flex items-center justify-end gap-2 bg-gray-50 rounded-b-xl">
              <button type="button" class="rounded px-4 py-2 bg-gray-200 hover:bg-gray-300 font-medium transition text-gray-700" @click="showRole=false">Cancel</button>
              <button class="rounded px-4 py-2 bg-blue-600 hover:bg-blue-750 text-white font-medium transition">Save</button>
            </div>
          </form>
        </div>
      </div>
    </template>

    {{-- Modal: Add Permission --}}
    <template x-teleport="body">
      <div x-show="showPerm" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center" style="display: none;">
        <!-- Backdrop overlay -->
        <div class="fixed inset-0" @click="showPerm=false"></div>

        <div class="relative z-50 w-full max-w-lg bg-white rounded-xl shadow-lg border transform transition-all">
          <div class="p-4 border-b flex items-center justify-between bg-gray-50 rounded-t-xl">
            <h3 class="font-semibold text-lg text-gray-900">Add Permission</h3>
            <button class="text-gray-400 hover:text-gray-600" @click="showPerm=false">✕</button>
          </div>
          <form method="post" action="{{ route('permissions.store') }}">
            @csrf
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm mb-1 font-medium text-gray-700">Name *</label>
                <input name="name" required class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
              </div>
              <div>
                <label class="block text-sm mb-1 font-medium text-gray-700">Guard *</label>
                <select name="guard_name" class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                  @foreach(($guards ?? ['web', 'api']) as $g)
                    <option value="{{ $g }}">{{ $g }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="p-4 border-t flex items-center justify-end gap-2 bg-gray-50 rounded-b-xl">
              <button type="button" class="rounded px-4 py-2 bg-gray-200 hover:bg-gray-300 font-medium transition text-gray-700" @click="showPerm=false">Cancel</button>
              <button class="rounded px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-medium transition">Save</button>
            </div>
          </form>
        </div>
      </div>
    </template>
  </div>

  <script>
    function accessUi() {
      return {
        showRole: false,
        showPerm: false,
        form: { 
          guard: 'web', 
          perms: {} 
        },
        allPermIds: @json(($permissions ?? collect())->pluck('id')),
        openAddRole() { 
          this.showRole = true; 
        }, 
        openAddPermission() { 
          this.showPerm = true; 
        },
        toggleAllPerms(on) {
          this.allPermIds.forEach(id => {
            this.form.perms[id] = !!on;
          });
        }
      }
    }
  </script>
</x-app-layout>