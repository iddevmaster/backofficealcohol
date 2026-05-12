<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="bg-white rounded-lg border p-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold">รายละเอียดองค์กร</h1>
                <div class="space-x-2">
                    @can('edit organizations')
                        <a href="{{ route('organizations.edit', $organization) }}"
                            class="rounded-md border px-4 py-2 hover:bg-gray-50">แก้ไข</a>
                    @endcan
                    <!-- <a href="{{ route('organizations.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a> -->
                </div>
            </div>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm text-gray-500">org_id</dt>
                    <dd class="font-medium break-words">{{ $organization->org_id }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">ชื่อ</dt>
                    <dd class="font-medium">{{ $organization->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">ตัวย่อองค์กร (org_code)</dt>
                    <dd class="font-medium">{{ $organization->org_code }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm text-gray-500">โลโก้</dt>
                    <dd class="font-medium break-words">
                        @if($organization->logo)
                            <img src="{{ $organization->logo }}" alt="logo" class="h-12">
                            <div class="text-xs text-gray-500 mt-1">{{ $organization->logo }}</div>
                        @else
                            —
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">สถานะ</dt>
                    <dd class="font-medium">{{ $organization->status ? 'ใช้งาน' : 'ปิด' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">อัปเดตล่าสุด</dt>
                    <dd class="font-medium">{{ $organization->updated_at->format('Y-m-d H:i') }}</dd>
                </div>
            </dl>
        </div>

        <div x-data="{ tab: 'branches' }" class="bg-white rounded-lg border p-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="tab = 'branches'"
                        :class="tab === 'branches' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        สาขา ({{ $organization->branches->count() }})
                    </button>
                    <button @click="tab = 'departments'"
                        :class="tab === 'departments' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        ฝ่าย ({{ $organization->departments->count() }})
                    </button>
                </nav>
            </div>

            <div class="mt-6">
                <!-- Branches Tab -->
                <div x-show="tab === 'branches'" x-cloak>
                    @if($organization->branches->count())
                        <div class="overflow-x-auto rounded-lg border">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 text-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">#</th>
                                        <th class="px-4 py-2 text-left">รหัสสาขา</th>
                                        <th class="px-4 py-2 text-left">ชื่อ</th>
                                        <th class="px-4 py-2 text-left">ที่อยู่</th>
                                        <th class="px-4 py-2 text-left">อัปเดตล่าสุด</th>
                                        <th class="px-4 py-2 text-right">การทำงาน</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($organization->branches as $b)
                                        <tr>
                                            <td class="px-4 py-2">{{ $b->id }}</td>
                                            <td class="px-4 py-2">
                                                <a class="text-indigo-600 hover:underline"
                                                    href="{{ route('branches.show', $b) }}">
                                                    {{ $b->brn_id }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2">{{ $b->name }}</td>
                                            <td class="px-4 py-2">
                                                ตำบล {{ $b->tambon->name ?? '—' }}
                                                อำเภอ {{ $b->amphur->name ?? '—' }}
                                                จังหวัด {{ $b->province->name ?? '—' }}
                                            </td>
                                            <td class="px-4 py-2">{{ $b->updated_at->format('Y-m-d H:i') }}</td>
                                            <td class="px-4 py-2 text-right space-x-1">
                                                @can('edit branches')
                                                    <a href="{{ route('branches.edit', $b) }}"
                                                        class="inline-flex rounded-md border px-3 py-1.5 hover:bg-gray-50">แก้ไข</a>
                                                @endcan
                                                @can('delete branches')
                                                    <form action="{{ route('branches.destroy', $b) }}" method="post" class="inline"
                                                        onsubmit="return confirm('ลบรายการนี้หรือไม่?');">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="inline-flex rounded-md bg-red-600 px-3 py-1.5 text-white hover:bg-red-700">ลบ</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 italic">ไม่พบข้อมูลสาขา</div>
                    @endif
                </div>

                <!-- Departments Tab -->
                <div x-show="tab === 'departments'" x-cloak>
                    @if($organization->departments->count())
                        <div class="overflow-x-auto rounded-lg border">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 text-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">#</th>
                                        <th class="px-4 py-2 text-left">รหัสฝ่าย</th>
                                        <th class="px-4 py-2 text-left">ชื่อฝ่าย</th>
                                        <th class="px-4 py-2 text-left">ชื่อสาขา</th>
                                        <th class="px-4 py-2 text-left">อัปเดตล่าสุด</th>
                                        <th class="px-4 py-2 text-right">การทำงาน</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($organization->departments as $dep)
                                        <tr>
                                            <td class="px-4 py-2">{{ $dep->id }}</td>
                                            <td class="px-4 py-2">
                                                <a href="{{ route('departments.show', $dep) }}"
                                                    class="text-indigo-600 hover:underline">
                                                    {{ $dep->dpm_id }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2">{{ $dep->name }}</td>
                                            <td class="px-4 py-2">{{ $dep->branches->name ?? '—' }}</td>
                                            <td class="px-4 py-2">{{ $dep->updated_at->format('Y-m-d H:i') }}</td>
                                            <td class="px-4 py-2 text-right space-x-1">
                                                @can('edit departments')
                                                    <a href="{{ route('departments.edit', $dep) }}"
                                                        class="inline-flex items-center rounded-md border px-3 py-1.5 hover:bg-gray-50">แก้ไข</a>
                                                @endcan
                                                @can('delete departments')
                                                    <form action="{{ route('departments.destroy', $dep) }}" method="post"
                                                        class="inline" onsubmit="return confirm('ลบรายการนี้หรือไม่?');">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-white hover:bg-red-700">
                                                            ลบ
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 italic">ไม่พบข้อมูลฝ่าย</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>