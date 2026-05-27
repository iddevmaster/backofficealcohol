<section>
    <header class="mb-6">
        <h3 class="text-md font-semibold text-gray-800">
            {{ __('แก้ไขรหัสผ่านบัญชี') }}
        </h3>
        <p class="mt-1 text-xs text-gray-500">
            {{ __('โปรดตรวจสอบให้แน่ใจว่าบัญชีของคุณใช้รหัสผ่านที่ยาวและปลอดภัยเพื่อความปลอดภัยของข้อมูล') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-4 max-w-xl">
            <!-- Current Password -->
            <div>
                <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ __('รหัสผ่านปัจจุบัน (Current Password) *') }}
                </label>
                <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition-colors duration-200" autocomplete="current-password" required />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5" />
            </div>

            <!-- New Password -->
            <div>
                <label for="update_password_password" class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ __('รหัสผ่านใหม่ (New Password) *') }}
                </label>
                <input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition-colors duration-200" autocomplete="new-password" required />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ __('ยืนยันรหัสผ่านใหม่ (Confirm Password) *') }}
                </label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition-colors duration-200" autocomplete="new-password" required />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5" />
            </div>
        </div>

        <!-- Submit Button and Save Toast -->
        <div class="flex items-center gap-4 border-t border-gray-100 pt-5 mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                {{ __('อัปเดตรหัสผ่าน') }}
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }"
                    x-show="show"
                    x-transition:leave="transition ease-in duration-1000"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-1.5 text-sm text-green-600 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ __('บันทึกรหัสผ่านใหม่เรียบร้อยแล้ว') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
