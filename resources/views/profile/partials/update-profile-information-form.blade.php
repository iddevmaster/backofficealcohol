<section>
    <header class="mb-6">
        <h3 class="text-md font-semibold text-gray-800">
            {{ __('แก้ไขข้อมูลผู้ดูแลระบบ') }}
        </h3>
        <p class="mt-1 text-xs text-gray-500">
            {{ __('กรอกข้อมูลชื่อผู้ใช้งาน ชื่อจริง นามสกุล และช่องทางการติดต่อของคุณ') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Prefix Selection -->
            <div>
                <label for="prefix_id" class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ __('คำนำหน้าชื่อ (Prefix) *') }}
                </label>
                <select id="prefix_id" name="prefix_id" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition-colors duration-200" required>
                    <option value="" disabled>{{ __('เลือกคำนำหน้า') }}</option>
                    @foreach(($prefixes ?? []) as $prefix)
                        <option value="{{ $prefix->id }}" @selected(old('prefix_id', $user->prefix_id) == $prefix->id)>
                            {{ $prefix->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-1.5" :messages="$errors->get('prefix_id')" />
            </div>

            <!-- Username Input -->
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ __('ชื่อผู้ใช้ (Username) *') }}
                </label>
                <input id="username" name="username" type="text" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition-colors duration-200" value="{{ old('username', $user->username) }}" required autocomplete="username" />
                <x-input-error class="mt-1.5" :messages="$errors->get('username')" />
            </div>

            <!-- First Name Input -->
            <div>
                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ __('ชื่อจริง (First Name) *') }}
                </label>
                <input id="first_name" name="first_name" type="text" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition-colors duration-200" value="{{ old('first_name', $user->first_name) }}" required autocomplete="given-name" />
                <x-input-error class="mt-1.5" :messages="$errors->get('first_name')" />
            </div>

            <!-- Last Name Input -->
            <div>
                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ __('นามสกุล (Last Name) *') }}
                </label>
                <input id="last_name" name="last_name" type="text" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition-colors duration-200" value="{{ old('last_name', $user->last_name) }}" required autocomplete="family-name" />
                <x-input-error class="mt-1.5" :messages="$errors->get('last_name')" />
            </div>

            <!-- Phone Number Input -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ __('เบอร์โทรศัพท์ติดต่อ (Phone Number)') }}
                </label>
                <input id="phone" name="phone" type="text" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition-colors duration-200" value="{{ old('phone', $user->phone) }}" autocomplete="tel" />
                <x-input-error class="mt-1.5" :messages="$errors->get('phone')" />
            </div>
        </div>

        <!-- Submit Button and Save Toast -->
        <div class="flex items-center gap-4 border-t border-gray-100 pt-5 mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                {{ __('บันทึกข้อมูล') }}
            </button>

            @if (session('status') === 'profile-updated')
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
                    <span>{{ __('บันทึกการเปลี่ยนแปลงเรียบร้อยแล้ว') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
