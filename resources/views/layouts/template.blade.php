<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ภาพรวมแดชบอร์ด - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<script type="module" src="https://static.rocket.new/rocket-web.js?_cfg=https%3A%2F%2Fadmindash5340back.builtwithrocket.new&_be=https%3A%2F%2Fapplication.rocket.new&_v=0.1.6"></script>
</head>

<head>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-background">
    <!-- Header -->
@include('template.header')
    <!-- Sidebar -->
    @include('template.sidebar')
    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-16 min-h-screen">
        <div class="p-6">
            <!-- Breadcrumb -->
            @include('template.breadcrumb')

           {{ $slot }}
            
        </div>
    </main>

    <!-- Footer -->
    @include('template.footer')

    <!-- JavaScript -->
    <script>
    // Check authentication
    const currentUser = JSON.parse(localStorage.getItem('currentUser') || 'null');
    if (!currentUser) {
        // window.location.href = 'login.html';
    } else {
        // Update user info in header
        document.getElementById('userName').textContent = currentUser.name;
        document.getElementById('userRole').textContent = currentUser.role === 'admin' ? 'Administrator' : 
                                                        currentUser.role === 'manager' ? 'Manager' : 'User';
    }

    // DOM Elements
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');
    const logoutButton = document.getElementById('logoutButton');

    // Sidebar Toggle (Mobile)
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOverlay.classList.toggle('hidden');
    });

    // Close sidebar when clicking overlay
    sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    });

    // User Menu Dropdown
    userMenuButton.addEventListener('click', function(e) {
        e.stopPropagation();
        userDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.classList.add('hidden');
        }
    });

    // Logout functionality
    logoutButton.addEventListener('click', function() {
        localStorage.removeItem('currentUser');
        window.location.href = 'login.html';
    });

    // Close sidebar on window resize (desktop)
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        }
    });

    // Metric cards click handlers
    document.querySelectorAll('.card-hover').forEach(card => {
        card.addEventListener('click', function() {
            // Add click animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // Chart interaction simulation
    const chartContainer = document.querySelector('.h-80');
    if (chartContainer) {
        chartContainer.addEventListener('mouseover', function() {
            this.style.cursor = 'crosshair';
        });
    }

    // Real-time updates simulation
    function updateMetrics() {
        const metrics = [
            { selector: '.text-2xl', values: ['2,847', '2,851', '2,849', '2,853'] },
            { selector: '.text-2xl:nth-of-type(2)', values: ['156', '157', '155', '158'] },
            { selector: '.text-2xl:nth-of-type(3)', values: ['1,234', '1,237', '1,231', '1,239'] }
        ];

        // Simulate random updates every 30 seconds
        setInterval(() => {
            metrics.forEach(metric => {
                const element = document.querySelector(metric.selector);
                if (element) {
                    const randomValue = metric.values[Math.floor(Math.random() * metric.values.length)];
                    element.textContent = randomValue;
                }
            });
        }, 30000);
    }

    // Initialize real-time updates
    updateMetrics();

    // Activity feed auto-scroll
    const activityFeed = document.querySelector('.space-y-4');
    if (activityFeed) {
        // Define sample activities data
        const sampleActivities = [
            { user: 'วิชัย สมบูรณ์', action: 'ส่งฟอร์มใหม่', time: 'เมื่อสักครู่' },
            { user: 'นิดา ใจดี', action: 'อัพเดทข้อมูล', time: '2 นาทีที่แล้ว' },
            { user: 'ระบบ', action: 'สำรองข้อมูลเสร็จสิ้น', time: '10 นาทีที่แล้ว' }
        ];

        // Add new activity items periodically
        setInterval(() => {
            const randomActivity = sampleActivities[Math.floor(Math.random() * sampleActivities.length)];
            const newActivity = document.createElement('div');
            newActivity.className = 'flex items-start space-x-3 opacity-0 transition-opacity duration-300';
            newActivity.innerHTML = `
                <div class="w-2 h-2 bg-primary-500 rounded-full mt-2 flex-shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-secondary-900">${randomActivity.user} ${randomActivity.action}</p>
                    <p class="text-xs text-secondary-500">${randomActivity.time}</p>
                </div>
            `;
            
            activityFeed.insertBefore(newActivity, activityFeed.firstChild);
            
            // Fade in new activity
            setTimeout(() => {
                newActivity.classList.remove('opacity-0');
            }, 100);
            
            // Remove old activities if more than 4
            const currentActivities = activityFeed.children;
            if (currentActivities.length > 4) {
                activityFeed.removeChild(currentActivities[currentActivities.length - 1]);
            }
        }, 45000);
    }
</script>
</body>
</html>