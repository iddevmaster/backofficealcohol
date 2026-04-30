<aside id="sidebar"
    class="fixed left-0 top-16 h-full w-64 bg-white border-r border-secondary-200 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <nav class="p-4 space-y-2">
        <!-- <a href="dashboard_overview.html" class="flex items-center space-x-3 px-3 py-2 rounded-md bg-primary-50 text-primary-700 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"/>
                </svg>
                <span>ภาพรวมแดชบอร์ด</span>
            </a> -->

        {{-- admin / staff / user

        <a href="{{ url('admin/finger') }}"
            class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Finger</span>
        </a>

        <a href="{{ url('departments') }}"
            class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Department</span>
        </a>

        <a href="{{ url('branches') }}"
            class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Branches</span>
        </a>

        <a href="{{ url('/usersUser') }}"
            class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Users</span>
        </a>
        <a href="{{ url('roles') }}"
            class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Role</span>
        </a> --}}

        {{-- Public --}}
        <div class="space-y-1 mb-4">
            <h3 class="px-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">General</h3>
            <a href="{{ url('/dashboard') }}"
                class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Dashboard</span>
            </a>
            @can('access reports')
                <a href="{{ url('admin/report') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Report</span>
                </a>
            @endcan
            @can('list histories')
                <a href="{{ url('admin/histories') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Test Histories</span>
                </a>
            @endcan
        </div>

        {{-- Master Data --}}
        <div class="space-y-1 mb-4">
            <h3 class="px-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Master Data</h3>
            @can('list employees')
                <a href="{{ url('admin/employees') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Employee</span>
                </a>
            @endcan
            @can('list finger')
                <a href="{{ url('admin/finger') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Finger</span>
                </a>
            @endcan
            @if(Auth::user()->org_id)
                @can('show organizations')
                    <a href="{{ route('organizations.show', Auth::user()->org_id) }}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Organization</span>
                    </a>
                @endcan
            @endif
        </div>

        {{-- Admin --}}
        <div class="space-y-1 mb-4">
            <h3 class="px-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Administration</h3>
            @can('list organizations')
                <a href="{{ url('admin/organizations') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Organizations</span>
                </a>
            @endcan
            @can('list branches')
                <a href="{{ url('admin/branches') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Branches</span>
                </a>
            @endcan
            @can('list departments')
                <a href="{{ url('admin/departments') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Department</span>
                </a>
            @endcan
            @can('list users')
                <a href="{{ url('admin/users') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Users</span>
                </a>
            @endcan
            @can('list devices')
                <a href="{{ url('admin/devices') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Devices</span>
                </a>
            @endcan
            @can('list deviceslog')
                <a href="{{ url('admin/deviceslog') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Devices Log</span>
                </a>
            @endcan
            @can('list roles')
                <a href="{{ url('admin/access') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Role</span>
                </a>
            @endcan
            @can('list prefixes')
                <a href="{{ url('admin/prefixes') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Prefixes</span>
                </a>
            @endcan
        </div>
        <!--
            <a href="data_tables_management.html" class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0V4a1 1 0 011-1h3M6 3h2m8 0h2m3 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1h3m8 0a1 1 0 011 1v16a1 1 0 01-1 1H8a1 1 0 01-1-1V4a1 1 0 011-1z"/>
                </svg>
                <span>จัดการตารางข้อมูล</span>
            </a>


            <a href="user_profile_settings.html" class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>การตั้งค่าโปรไฟล์</span>
            </a>


            <hr class="my-4 border-secondary-200" />


            <div class="space-y-2">
                <h3 class="px-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">ระบบ</h3>
                <a href="javascript:void(0)" class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>การตั้งค่าระบบ</span>
                </a>
                <a href="javascript:void(0)" class="flex items-center space-x-3 px-3 py-2 rounded-md text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>รายงาน</span>
                </a>
            </div> -->
    </nav>
</aside>