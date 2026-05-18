<x-app-layout>
  <style>[x-cloak] { display: none !important; }</style>
  <div x-data="deviceUi()" class="space-y-6">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h1 class="text-2xl font-semibold">อุปกรณ์</h1>
        <p class="text-slate-500">Device list and hardware management</p>
      </div>
      <button @click="openAddDevice()"
         class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 font-medium transition shadow-sm">
        + อุปกรณ์
      </button>
    </div>

    <form method="get" class="mb-4">
      <div class="flex gap-2">
        <input type="text" name="q" placeholder="ค้นหา อุปกรณ์" value="{{ $q }}"
               class="flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
        <button class="rounded-md border px-4 py-2 hover:bg-gray-50 bg-white font-medium text-gray-700">ค้นหา</button>
      </div>
    </form>

    @if (session('success'))
        <div class="mb-4 rounded-md border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
          {{ session('success') }}
        </div>
    @endif

    @if($devices->count())
      <div class="overflow-x-auto rounded-lg border bg-white shadow-sm">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-semibold">#</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Model</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Serial</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">IP</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Created</th>
              <th class="px-4 py-2 text-left text-xs font-semibold">Status</th>
              <th class="px-4 py-2"></th>
            </tr>
          </thead>
          <tbody class="divide-y text-gray-800">
            @foreach($devices as $d)
              <tr>
                <td class="px-4 py-2">{{ $d->id }}</td>
                <td class="px-4 py-2 font-medium">{{ $d->model }}</td>
                <td class="px-4 py-2">{{ $d->serial_num }}</td>
                <td class="px-4 py-2 text-gray-500">{{ $d->ip_address ?? '-' }}</td>
                <td class="px-4 py-2 text-gray-500">{{ $d->created_date?->format('Y-m-d H:i') }}</td>
                <td class="px-4 py-2">
                  @if($d->status == 1)
                    <span class="rounded bg-emerald-100 text-emerald-800 px-2 py-0.5 text-xs font-semibold">Active</span>
                  @else
                    <span class="rounded bg-gray-200 text-gray-700 px-2 py-0.5 text-xs font-semibold">Inactive</span>
                  @endif
                </td>
                <td class="px-4 py-2 text-right whitespace-nowrap">
                  <a href="{{ route('devices.show',$d) }}" class="text-blue-600 hover:text-blue-800 font-medium">ดู</a>
                  <a href="{{ route('devices.edit',$d) }}" class="ml-3 text-amber-600 hover:text-amber-800 font-medium">แก้ไข</a>

                  <form action="{{ route('devices.destroy',$d) }}" method="post" class="inline" onsubmit="return confirm('ลบอุปกรณ์นี้?')">
                    @csrf @method('DELETE')
                    <button class="ml-3 text-red-600 hover:text-red-800 font-medium">ลบ</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4">{{ $devices->links() }}</div>
    @else
      <div class="rounded-md border bg-white p-6 text-center text-gray-600 shadow-sm">
        ไม่พบข้อมูล
      </div>
    @endif

    {{-- Modal: Add Device --}}
    <template x-teleport="body">
      <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center" style="display: none;">
        <!-- Backdrop overlay -->
        <div class="fixed inset-0" @click="showAddModal=false"></div>

        <div class="relative z-50 w-full max-w-2xl bg-white rounded-xl shadow-lg border transform transition-all my-8">
          <div class="p-4 border-b flex items-center justify-between bg-gray-50 rounded-t-xl">
            <h3 class="font-semibold text-lg text-gray-900">เพิ่มอุปกรณ์</h3>
            <button class="text-gray-400 hover:text-gray-600" @click="showAddModal=false">✕</button>
          </div>
          <form method="post" action="{{ route('devices.store') }}">
            @csrf
            
            <div class="p-6 space-y-4">
              @if ($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 text-red-700 rounded text-sm">
                  <p class="font-semibold">โปรดกรอกข้อมูลให้ถูกต้อง:</p>
                  <ul class="list-disc pl-5 mt-1 space-y-1">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div>
                  <label class="block text-sm font-medium mb-1 text-gray-700">Model *</label>
                  <input type="text" name="model" class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required
                         value="{{ old('model', '') }}">
                </div>

                <div>
                  <label class="block text-sm font-medium mb-1 text-gray-700">Serial Number *</label>
                  <input type="text" name="serial_num" class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required
                         value="{{ old('serial_num', '') }}">
                </div>

                <div>
                  <label class="block text-sm font-medium mb-1 text-gray-700">Sensor SN</label>
                  <input type="text" name="sensor_sn" class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                         value="{{ old('sensor_sn', '') }}">
                </div>

                <div>
                  <label class="block text-sm font-medium mb-1 text-gray-700">Sensor Body SN</label>
                  <input type="text" name="sensor_body_sn" class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                         value="{{ old('sensor_body_sn', '') }}">
                </div>

              </div>
            </div>

            <div class="p-4 border-t flex items-center justify-end gap-2 bg-gray-50 rounded-b-xl">
              <button type="button" class="rounded px-4 py-2 bg-gray-200 hover:bg-gray-300 font-medium transition text-gray-700" @click="showAddModal=false">Cancel</button>
              <button class="rounded px-4 py-2 bg-blue-600 hover:bg-blue-750 text-white font-medium transition">Save</button>
            </div>
          </form>
        </div>
      </div>
    </template>

  </div>

  <script>
    function deviceUi() {
      return {
        showAddModal: {{ $errors->any() ? 'true' : 'false' }},
        openAddDevice() {
          this.showAddModal = true;
        }
      }
    }
  </script>
</x-app-layout>
