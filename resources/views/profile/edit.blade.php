<x-app-layout>
    @php
        $orgName = $user->organize?->name ?? '—';
        $branchName = \App\Models\Branches::find($user->brn_id)?->name ?? '—';
        $deptName = \App\Models\Department::find($user->dpm_id)?->name ?? '—';
    @endphp

    <!-- Gradient Header Banner -->
    <div
        class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-700 rounded-2xl p-6 text-white shadow-md mb-8">
        <!-- Decorative blur shapes for rich aesthetics -->
        <div
            class="absolute right-0 top-0 -mt-10 -mr-10 w-44 h-44 bg-white/10 rounded-full blur-2xl pointer-events-none animate-pulse">
        </div>
        <div class="absolute left-1/3 bottom-0 -mb-16 w-32 h-32 bg-white/5 rounded-full blur-xl pointer-events-none">
        </div>

        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6 text-center md:text-left">
            <div class="relative group">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name ?: $user->username) }}&color=3b82f6&background=eff6ff&size=128"
                    alt="User Avatar"
                    class="w-24 h-24 rounded-full border-4 border-white/20 shadow-md object-cover transform transition duration-300 group-hover:scale-105"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&color=3b82f6&background=eff6ff'; this.onerror=null;" />
            </div>

            <div class="flex-1">
                <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2 justify-center md:justify-start">
                    <h1 class="text-2xl font-bold tracking-tight">
                        {{ $user->first_name ? ($user->prefix?->name ?? '') . ' ' . $user->first_name . ' ' . $user->last_name : $user->username }}
                    </h1>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-md self-center border border-white/10">
                        {{ $user->role?->name ?? 'ผู้ดูแลระบบ' }}
                    </span>
                </div>
                <p class="text-white/80 text-sm mb-4">ชื่อผู้ใช้ (Username): <span
                        class="font-mono bg-white/10 px-2 py-0.5 rounded text-white">{{ $user->username }}</span></p>

                <!-- Badges showing user details -->
                <div class="flex flex-wrap gap-3 justify-center md:justify-start text-xs">
                    <div
                        class="flex items-center bg-white/10 px-3 py-1.5 rounded-lg border border-white/10 shadow-sm backdrop-blur-sm">
                        <span class="text-white/60 mr-1.5">องค์กร:</span>
                        <span class="font-semibold text-white">{{ $orgName }}</span>
                    </div>
                    <div
                        class="flex items-center bg-white/10 px-3 py-1.5 rounded-lg border border-white/10 shadow-sm backdrop-blur-sm">
                        <span class="text-white/60 mr-1.5">สาขา:</span>
                        <span class="font-semibold text-white">{{ $branchName }}</span>
                    </div>
                    <div
                        class="flex items-center bg-white/10 px-3 py-1.5 rounded-lg border border-white/10 shadow-sm backdrop-blur-sm">
                        <span class="text-white/60 mr-1.5">แผนก:</span>
                        <span class="font-semibold text-white">{{ $deptName }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form Column (Left) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Profile Info Form Card -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-150 p-6 sm:p-8 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                    <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">ข้อมูลส่วนตัว (Profile Details)</h2>
                        <p class="text-xs text-gray-500">อัปเดตข้อมูลบัญชีและเบอร์ติดต่อของคุณ</p>
                    </div>
                </div>

                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Password Update Form Card -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-150 p-6 sm:p-8 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                    <div class="p-2.5 bg-amber-50 rounded-xl text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">ความปลอดภัย (Password & Security)</h2>
                        <p class="text-xs text-gray-500">เปลี่ยนรหัสผ่านเพื่อความปลอดภัยของบัญชีผู้ใช้</p>
                    </div>
                </div>

                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Sidebar Details / Meta Column (Right) -->
        <div class="space-y-8">
            <!-- Account Summary / Status Card -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-150 p-6 hover:shadow-md transition-shadow duration-300">
                <h3 class="text-md font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">ข้อมูลบัญชีผู้ใช้
                    (Account Details)</h3>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">สถานะบัญชี:</span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $user->status ? 'เปิดการใช้งานปกติ' : 'ระงับการใช้งาน' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">ตำแหน่งบทบาท (Role):</span>
                        <span class="font-semibold text-gray-800">{{ $user->role?->name ?? 'ผู้ใช้ทั่วไป' }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">เบอร์โทรศัพท์ติดต่อ:</span>
                        <span class="font-medium text-gray-800">{{ $user->phone ?? 'ไม่ได้ระบุ' }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">สร้างบัญชีเมื่อ:</span>
                        <span
                            class="text-gray-700 font-mono text-xs">{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '—' }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-500">อัปเดตล่าสุดเมื่อ:</span>
                        <span
                            class="text-gray-700 font-mono text-xs">{{ $user->updated_at ? $user->updated_at->format('Y-m-d H:i') : '—' }}</span>
                    </div>
                </div>
            </div>

            <!-- Danger Zone / Delete Account Card -->
            {{-- <div class="bg-red-50/30 rounded-2xl shadow-sm border border-red-100 p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-md font-bold text-red-800">พื้นที่อันตราย (Danger Zone)</h3>
                </div>
                <p class="text-xs text-red-700/80 mb-4 leading-relaxed">เมื่อดำเนินการลบบัญชีแล้ว ข้อมูลและประวัติทั้งหมดที่เชื่อมโยงกับบัญชีผู้ใช้นี้จะถูกทำลายถาวรทันทีและไม่สามารถกู้คืนได้</p>
                
                @include('profile.partials.delete-user-form')
            </div> --}}
        </div>
    </div>
</x-app-layout>
