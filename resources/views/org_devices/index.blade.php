<x-app-layout>
    <div x-data="{
        open: {{ $errors->any() && !old('id') ? 'true' : 'false' }},
        editOpen: {{ $errors->any() && old('id') ? 'true' : 'false' }},
        pwdOpen: false,
        editForm: {
            id: '{{ old('id') }}',
            name: '{{ old('name') }}',
            serial_num: '{{ old('serial_num') }}',
            org_id: '{{ old('org_id') }}',
            brn_id: '{{ old('brn_id') }}',
            note: '{{ old('note') }}'
        },
        pwdForm: {
            id: '',
            public_pwd: '',
            original_pwd: ''
        },
        openEditModal(device) {
            this.editForm.id = device.id;
            this.editForm.name = device.name;
            this.editForm.serial_num = device.serial_num;
            this.editForm.org_id = device.org_id;
            this.editForm.brn_id = device.brn_id;
            this.editForm.note = device.note;
    
            // Fetch branches for edit modal
            const editBranchSelect = document.getElementById('edit_brn_select');
            fetchAndPopulateBranches(device.org_id, editBranchSelect, device.brn_id);
    
            this.editOpen = true;
        },
        openPwdModal(device) {
            this.pwdForm.id = device.id;
            this.pwdForm.public_pwd = device.public_pwd || '';
            this.pwdForm.original_pwd = device.public_pwd || '';
            this.pwdOpen = true;
        }
    }">

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold">อุปกรณ์ขององค์กร</h1>
            @can('create org_devices')
                <button @click="open = true"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                    + อุปกรณ์ขององค์กร
                </button>
            @endcan
        </div>

        <form method="get" class="mb-4">
            <div class="flex gap-2">
                <input type="text" name="q" placeholder="ค้นหา อุปกรณ์ขององค์กร" value="{{ $q }}"
                    class="flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <button class="rounded-md border px-4 py-2 hover:bg-gray-50">ค้นหา</button>
                @if ($q)
                    <a href="{{ route('org-devices.index') }}"
                        class="rounded-md border px-4 py-2 hover:bg-gray-50 flex items-center justify-center">ล้าง</a>
                @endif
            </div>
        </form>

        @if (session('success'))
            <div class="mb-4 rounded-md border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($devices->count())
            <div class="overflow-x-auto rounded-lg border bg-white">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold">#</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">ชื่ออุปกรณ์</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">Serial Number</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">องค์กร</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">สาขา</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">หมายเหตุ</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">บันทึกเมื่อ</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($devices as $idx => $d)
                            <tr>
                                <td class="px-4 py-2">
                                    {{ ($devices->currentPage() - 1) * $devices->perPage() + $idx + 1 }}</td>
                                <td class="px-4 py-2 font-semibold">{{ $d->name }}</td>
                                <td class="px-4 py-2">{{ $d->serial_num }}</td>
                                <td class="px-4 py-2">{{ $d->organization->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $d->branch->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $d->note ?? '-' }}</td>
                                <td class="px-4 py-2 text-gray-500">
                                    {{ $d->created_at ? $d->created_at->format('Y-m-d H:i') : '-' }}</td>
                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    <button @click="openPwdModal({{ json_encode($d) }})"
                                        class="ml-3 text-indigo-600 hover:text-indigo-800 font-medium">รหัสผ่าน</button>
                                    @can('edit org_devices')
                                        <button @click="openEditModal({{ json_encode($d) }})"
                                            class="text-amber-600 hover:text-amber-800 font-medium">แก้ไข</button>
                                    @endcan
                                    @can('delete org_devices')
                                        <form action="{{ route('org-devices.destroy', $d) }}" method="post" class="inline"
                                            onsubmit="return confirm('ลบอุปกรณ์นี้?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="ml-3 text-red-600 hover:text-red-800 font-medium">ลบ</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $devices->links() }}</div>
        @else
            <div class="rounded-md border bg-white p-6 text-center text-gray-600">
                ไม่พบข้อมูล
            </div>
        @endif

        <!-- ADD FORM MODAL -->
        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto bg-black/50" style="display: none;">

            <!-- Backdrop overlay -->
            <div class="fixed inset-0" @click="open = false"></div>

            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Modal Box -->
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border">

                    <!-- Header -->
                    <div class="bg-gray-100 px-4 py-3 border-b flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            เพิ่มอุปกรณ์ขององค์กร
                        </h3>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Body -->
                    <form action="{{ route('org-devices.store') }}" method="post" class="p-4 space-y-4">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium mb-1">ชื่ออุปกรณ์ *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full rounded border-gray-300">
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Serial Number -->
                        <div>
                            <label for="serial_num" class="block text-sm font-medium mb-1">Serial Number *</label>
                            <select name="serial_num" id="serial_num" required class="w-full rounded border-gray-300">
                                <option value="">-- เลือก Serial Number --</option>
                                @foreach ($masterDevices as $masterDevice)
                                    <option value="{{ $masterDevice->serial_num }}"
                                        {{ old('serial_num') == $masterDevice->serial_num ? 'selected' : '' }}>
                                        {{ $masterDevice->serial_num }} ({{ $masterDevice->model }})
                                    </option>
                                @endforeach
                            </select>
                            @error('serial_num')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Organization Select -->
                        <div>
                            <label for="org_select" class="block text-sm font-medium mb-1">องค์กร *</label>
                            <select name="org_id" id="org_select" required class="w-full rounded border-gray-300">
                                <option value="">-- เลือกองค์กร --</option>
                                @foreach ($organizations as $org)
                                    <option value="{{ $org->id }}"
                                        {{ old('org_id') == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }} ({{ $org->org_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('org_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Branch Select -->
                        <div>
                            <label for="brn_select" class="block text-sm font-medium mb-1">สาขา *</label>
                            <select name="brn_id" id="brn_select" required class="w-full rounded border-gray-300">
                                <option value="">-- เลือกสาขา (กรุณาเลือกองค์กรก่อน) --</option>
                            </select>
                            @error('brn_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Note -->
                        <div>
                            <label for="note" class="block text-sm font-medium mb-1">หมายเหตุ</label>
                            <input type="text" name="note" id="note" value="{{ old('note') }}"
                                class="w-full rounded border-gray-300">
                            @error('note')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 pt-2 border-t justify-end">
                            <button type="submit" class="rounded bg-blue-600 text-white px-4 py-2">บันทึก</button>
                            <button type="button" @click="open = false"
                                class="rounded bg-gray-200 px-4 py-2">ยกเลิก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- EDIT FORM MODAL -->
        <div x-show="editOpen" class="fixed inset-0 z-50 overflow-y-auto bg-black/50" style="display: none;">

            <!-- Backdrop overlay -->
            <div class="fixed inset-0" @click="editOpen = false"></div>

            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Modal Box -->
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border">

                    <!-- Header -->
                    <div class="bg-gray-100 px-4 py-3 border-b flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            แก้ไขอุปกรณ์ขององค์กร
                        </h3>
                        <button @click="editOpen = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Body -->
                    <form :action="'/admin/org-devices/' + editForm.id" method="post" class="p-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" :value="editForm.id">

                        <!-- Name -->
                        <div>
                            <label for="edit_name" class="block text-sm font-medium mb-1">ชื่ออุปกรณ์ *</label>
                            <input type="text" name="name" id="edit_name" :value="editForm.name" required
                                class="w-full rounded border-gray-300" x-model="editForm.name">
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @php
                            $isAdmin = auth()
                                ->user()
                                ->hasRole(['super-admin', 'admin']);
                        @endphp

                        <!-- Serial Number -->
                        <div>
                            <label for="edit_serial_num" class="block text-sm font-medium mb-1">Serial Number
                                *</label>
                            <select name="serial_num" id="edit_serial_num" required
                                class="w-full rounded border-gray-300 {{ !$isAdmin ? 'bg-gray-100 cursor-not-allowed text-gray-500' : '' }}"
                                {{ !$isAdmin ? 'disabled' : '' }} x-model="editForm.serial_num">
                                <option value="">-- เลือก Serial Number --</option>
                                @foreach ($masterDevices as $masterDevice)
                                    <option value="{{ $masterDevice->serial_num }}">
                                        {{ $masterDevice->serial_num }} ({{ $masterDevice->model }})
                                    </option>
                                @endforeach
                            </select>
                            @if (!$isAdmin)
                                <input type="hidden" name="serial_num" :value="editForm.serial_num">
                            @endif
                            @error('serial_num')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Organization Select -->
                        <div>
                            <label for="edit_org_select" class="block text-sm font-medium mb-1">องค์กร *</label>
                            <select name="org_id" id="edit_org_select" required
                                class="w-full rounded border-gray-300 {{ !$isAdmin ? 'bg-gray-100 cursor-not-allowed text-gray-500' : '' }}"
                                {{ !$isAdmin ? 'disabled' : '' }} x-model="editForm.org_id"
                                @change="fetchAndPopulateBranches($event.target.value, document.getElementById('edit_brn_select'))">
                                <option value="">-- เลือกองค์กร --</option>
                                @foreach ($organizations as $org)
                                    <option value="{{ $org->id }}">
                                        {{ $org->name }} ({{ $org->org_code }})
                                    </option>
                                @endforeach
                            </select>
                            @if (!$isAdmin)
                                <input type="hidden" name="org_id" :value="editForm.org_id">
                            @endif
                            @error('org_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Branch Select -->
                        <div>
                            <label for="edit_brn_select" class="block text-sm font-medium mb-1">สาขา *</label>
                            <select name="brn_id" id="edit_brn_select" required
                                class="w-full rounded border-gray-300 {{ !$isAdmin ? 'bg-gray-100 cursor-not-allowed text-gray-500' : '' }}"
                                {{ !$isAdmin ? 'disabled' : '' }} x-model="editForm.brn_id">
                                <option value="">-- เลือกสาขา (กรุณาเลือกองค์กรก่อน) --</option>
                            </select>
                            @if (!$isAdmin)
                                <input type="hidden" name="brn_id" :value="editForm.brn_id">
                            @endif
                            @error('brn_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Note -->
                        <div>
                            <label for="edit_note" class="block text-sm font-medium mb-1">หมายเหตุ</label>
                            <input type="text" name="note" id="edit_note" :value="editForm.note"
                                class="w-full rounded border-gray-300" x-model="editForm.note">
                            @error('note')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 pt-2 border-t justify-end">
                            <button type="submit" class="rounded bg-blue-600 text-white px-4 py-2">บันทึก</button>
                            <button type="button" @click="editOpen = false"
                                class="rounded bg-gray-200 px-4 py-2">ยกเลิก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SET PASSWORD MODAL -->
        <div x-show="pwdOpen" class="fixed inset-0 z-50 overflow-y-auto bg-black/50" style="display: none;">
            <!-- Backdrop overlay -->
            <div class="fixed inset-0" @click="pwdOpen = false"></div>

            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Modal Box -->
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border">
                    <!-- Header -->
                    <div class="bg-gray-100 px-4 py-3 border-b flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            ตั้งค่ารหัสผ่านสาธารณะ (Set Public Password)
                        </h3>
                        <button @click="pwdOpen = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Body -->
                    <form :action="'/admin/org-devices/' + pwdForm.id + '/set-pwd'" method="post"
                        class="p-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Current Password Display -->
                        <div
                            class="mb-4 p-3 bg-gray-50 border rounded-md text-sm text-gray-700 flex items-center justify-between">
                            <span class="font-semibold text-gray-700">รหัสผ่านปัจจุบัน (Current Password):</span>
                            <span x-text="pwdForm.original_pwd ? pwdForm.original_pwd : 'ไม่มี (None)'"
                                class="font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100"></span>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="public_pwd"
                                class="block text-sm font-medium mb-1 text-gray-700">รหัสผ่านสำหรับสาธารณะ ใหม่ (6
                                หลัก)</label>
                            <input type="text" name="public_pwd" id="public_pwd" :value="pwdForm.public_pwd"
                                class="w-full rounded border-gray-300" x-model="pwdForm.public_pwd"
                                @input="pwdForm.public_pwd = pwdForm.public_pwd.replace(/[^0-9]/g, '').slice(0, 6)"
                                inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                                placeholder="กรอกรหัสผ่าน 6 หลัก (เว้นว่างไว้เพื่อไม่ใช้รหัสผ่าน)">
                            <p class="text-xs text-gray-500 mt-1">รหัสผ่านตัวเลข 6 หลัก
                                ที่ใช้สำหรับเข้าถึงอุปกรณ์ในโหมดสาธารณะ</p>
                            <p x-show="pwdForm.public_pwd.length > 0 && pwdForm.public_pwd.length < 6"
                                class="text-xs text-red-600 mt-1">
                                รหัสผ่านต้องมีความยาว 6 หลัก (ปัจจุบันมีความยาว <span
                                    x-text="pwdForm.public_pwd.length"></span> หลัก)
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 pt-2 border-t justify-end">
                            <button type="submit"
                                :disabled="pwdForm.public_pwd.length > 0 && pwdForm.public_pwd.length < 6"
                                :class="pwdForm.public_pwd.length > 0 && pwdForm.public_pwd.length < 6 ?
                                    'opacity-50 cursor-not-allowed bg-blue-600' : 'hover:bg-blue-700 bg-blue-600'"
                                class="rounded text-white px-4 py-2">บันทึก</button>
                            <button type="button" @click="pwdOpen = false"
                                class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">ยกเลิก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts for dynamic branches loading -->
    @push('scripts')
        <script>
            function fetchAndPopulateBranches(orgId, selectElement, selectedBranchId = null) {
                if (!orgId) {
                    selectElement.innerHTML = '<option value="">-- เลือกสาขา (กรุณาเลือกองค์กรก่อน) --</option>';
                    return;
                }

                selectElement.innerHTML = '<option value="">กำลังโหลดสาขา...</option>';

                fetch(`/api/orgs/${orgId}/branches`)
                    .then(response => response.json())
                    .then(data => {
                        selectElement.innerHTML = '<option value="">-- เลือกสาขา --</option>';
                        data.forEach(branch => {
                            const option = document.createElement('option');
                            option.value = branch.id;
                            option.textContent = branch.name;
                            if (selectedBranchId && branch.id == selectedBranchId) {
                                option.selected = true;
                            }
                            selectElement.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching branches:', error);
                        selectElement.innerHTML = '<option value="">เกิดข้อผิดพลาดในการโหลดสาขา</option>';
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const orgSelect = document.getElementById('org_select');
                const branchSelect = document.getElementById('brn_select');
                const oldBranchId = "{{ old('brn_id') }}";

                const editOrgSelect = document.getElementById('edit_org_select');
                const editBranchSelect = document.getElementById('edit_brn_select');
                const oldEditBranchId = "{{ old('brn_id') }}";
                const oldEditOrgId = "{{ old('org_id') }}";
                const oldId = "{{ old('id') }}";

                // Add form listeners
                if (orgSelect.value) {
                    fetchAndPopulateBranches(orgSelect.value, branchSelect, oldBranchId);
                }
                orgSelect.addEventListener('change', function() {
                    fetchAndPopulateBranches(this.value, branchSelect);
                });

                // Edit form recovery on reload (if validation error occurs)
                if (oldId && oldEditOrgId) {
                    fetchAndPopulateBranches(oldEditOrgId, editBranchSelect, oldEditBranchId);
                }
            });
        </script>
    @endpush
</x-app-layout>
