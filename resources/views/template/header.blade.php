    <header class="fixed top-0 left-0 right-0 bg-white border-b border-secondary-200 z-40">
        <div class="flex items-center justify-between px-4 py-3">
            <!-- Left Section: Logo & Menu Toggle -->
            <div class="flex items-center space-x-4">
                <button id="sidebarToggle" class="p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-primary-500 lg:hidden">
                    <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-semibold text-secondary-800 hidden sm:block">ระบบจัดการผู้ดูแล</h1>
                </div>
            </div>

            <!-- Right Section: User Menu -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.07 2.82l3.93 3.93-3.93 3.93-3.93-3.93 3.93-3.93z"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-error-500 rounded-full"></span>
                </button>

                <!-- User Profile Dropdown -->
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center space-x-3 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="User Avatar" class="w-8 h-8 rounded-full object-cover" onerror="this.src='https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'; this.onerror=null;" />
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-secondary-800" id="userName">ผู้ดูแลระบบ</p>
                            <p class="text-xs text-secondary-500" id="userRole">Administrator</p>
                        </div>
                        <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-secondary-200 z-50">
                        <div class="py-1">
                            <a href="user_profile_settings.html" class="flex items-center px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                โปรไฟล์ของฉัน
                            </a>
                            <a href="javascript:void(0)" class="flex items-center px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                การตั้งค่า
                            </a>
                            <hr class="my-1 border-secondary-200" />

                            <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                            <button id="logoutButton" class="flex items-center w-full px-4 py-2 text-sm text-error-600 hover:bg-error-50">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                ออกจากระบบ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
