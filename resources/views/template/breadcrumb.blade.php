@php
    $segments = request()->segments();
    $breadcrumbs = [];

    // Thai translation mapping for URL segments to make it feel local and premium
    $segmentTranslations = [
        'admin' => 'ผู้ดูแลระบบ',
        'dashboard' => 'ภาพรวมแดชบอร์ด',
        'profile' => 'ข้อมูลส่วนตัว',
        
        // Modules
        'departments' => 'จัดการแผนก',
        'departmentsUser' => 'แผนก',
        'branches' => 'จัดการสาขา',
        'branchesUser' => 'สาขา',
        'organizations' => 'จัดการองค์กร',
        'prefixes' => 'จัดการคำนำหน้าชื่อ',
        'users' => 'จัดการผู้ใช้งาน',
        'usersUser' => 'ผู้ใช้งาน',
        'devices' => 'จัดการอุปกรณ์',
        'org-devices' => 'อุปกรณ์ขององค์กร',
        'access' => 'จัดการสิทธิ์การใช้งาน',
        'report' => 'รายงาน',
        'roles' => 'บทบาทหน้าที่',
        'permissions' => 'สิทธิ์การใช้งาน',
        'employees' => 'จัดการพนักงาน',
        'deviceslog' => 'ประวัติการใช้งานอุปกรณ์',
        'histories' => 'ประวัติการทดสอบ',
        'anonymous-tests' => 'ประวัติการทดสอบแบบไม่ระบุตัวตน',
        'device-scans' => 'ประวัติการสแกนอุปกรณ์',
        'finger' => 'ลายนิ้วมือ',
        
        // Actions
        'create' => 'เพิ่มข้อมูล',
        'edit' => 'แก้ไขข้อมูล',
        'show' => 'รายละเอียด',
    ];

    // Check if custom breadcrumbs are passed from the view/controller for maximum flexibility
    if (isset($customBreadcrumbs) && is_array($customBreadcrumbs)) {
        $breadcrumbs = $customBreadcrumbs;
    } else {
        // Start with Home pointing to dashboard
        $breadcrumbs[] = [
            'title' => 'หน้าแรก',
            'url' => url('/dashboard'),
            'clickable' => true,
        ];

        $accumulatedUrl = '';
        foreach ($segments as $index => $segment) {
            // Skip dashboard segment to avoid duplicating "หน้าแรก" with "ภาพรวมแดชบอร์ด" at the root level
            if ($segment === 'dashboard') {
                continue;
            }

            $accumulatedUrl .= '/' . $segment;

            // Determine if segment is numeric/ID or a dynamic slug/parameter
            $isId = is_numeric($segment) || (strlen($segment) > 8 && preg_match('/^[a-f0-9\-]+$/i', $segment));
            
            $title = $segmentTranslations[$segment] ?? ucfirst($segment);
            if ($isId) {
                $title = 'รายละเอียด';
            }

            // Grouping prefix segment like 'admin' should not be clickable since it has no direct route
            $clickable = ($segment !== 'admin');

            $breadcrumbs[] = [
                'title' => $title,
                'url' => $clickable ? url($accumulatedUrl) : null,
                'clickable' => $clickable,
            ];
        }
    }
@endphp

<nav class="mb-6" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm text-secondary-600">
        @foreach ($breadcrumbs as $index => $item)
            @if ($index > 0)
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-secondary-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
            @endif

            @if ($index === count($breadcrumbs) - 1)
                <!-- Last item (Active page) -->
                <li class="text-secondary-900 font-semibold" aria-current="page">
                    {{ $item['title'] }}
                </li>
            @elseif (isset($item['clickable']) && !$item['clickable'])
                <!-- Non-clickable intermediate item (e.g. 'admin' grouping prefix) -->
                <li class="text-secondary-500 font-medium">
                    {{ $item['title'] }}
                </li>
            @else
                <!-- Clickable intermediate item -->
                <li>
                    <a href="{{ $item['url'] }}" class="hover:text-primary-600 transition-colors duration-200 font-medium">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>

