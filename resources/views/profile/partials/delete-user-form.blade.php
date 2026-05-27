<section class="space-y-6">
    <header>
        <h4 class="text-sm font-bold text-red-900 mb-1">
            {{ __('ลบบัญชีผู้ใช้งานถาวร') }}
        </h4>
        <p class="text-xs text-red-700/80 leading-relaxed">
            {{ __('เมื่อบัญชีของคุณถูกลบ ข้อมูลและประวัติการตรวจวัดทั้งหมดจะถูกลบออกอย่างถาวรโดยไม่สามารถเรียกคืนได้') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg shadow-sm transition duration-200"
    >
        {{ __('ลบบัญชีของฉัน') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white rounded-2xl border border-gray-150">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900 mb-2">
                {{ __('ต้องการลบบัญชีผู้ใช้ของคุณใช่หรือไม่?') }}
            </h2>

            <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                {{ __('โปรดป้อนรหัสผ่านปัจจุบันของคุณเพื่อยืนยันว่าคุณต้องการลบบัญชีผู้ใช้นี้อย่างถาวร') }}
            </p>

            <div class="mt-4">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full md:w-3/4 rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-red-500 focus:ring-1 focus:ring-red-500 text-sm transition-colors duration-200"
                    placeholder="{{ __('ป้อนรหัสผ่านเพื่อยืนยัน') }}"
                    required
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 border border-gray-350 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition duration-200">
                    {{ __('ยกเลิก') }}
                </button>

                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200">
                    {{ __('ลบบัญชีผู้ใช้') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
