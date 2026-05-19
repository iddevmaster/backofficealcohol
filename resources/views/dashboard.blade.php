<x-app-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-secondary-900 mb-2">ภาพรวมแดชบอร์ด (Overview Dashboard)</h1>
        <p class="text-secondary-600">ข้อมูลสรุปและสถิติการตรวจวัดแอลกอฮอล์</p>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Total Tests Today -->
        <div class="card p-6 card-hover shadow-sm border border-secondary-100 rounded-lg bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-600 mb-1">จำนวนการตรวจวันนี้</p>
                    <p class="text-2xl font-semibold text-secondary-900">{{ number_format($totalTestsToday) }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Failed Tests Today -->
        <div class="card p-6 card-hover shadow-sm border border-secondary-100 rounded-lg bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-600 mb-1">พบแอลกอฮอล์ (วันนี้)</p>
                    <p class="text-2xl font-semibold text-danger-600">{{ number_format($failedTestsToday) }}</p>
                </div>
                <div class="w-12 h-12 bg-danger-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Devices -->
        <div class="card p-6 card-hover shadow-sm border border-secondary-100 rounded-lg bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-600 mb-1">เครื่อง Kiosk ที่ทำงานปกติ</p>
                    <p class="text-2xl font-semibold text-success-600">{{ number_format($activeDevices) }}</p>
                </div>
                <div class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Registered Employees -->
        <div class="card p-6 card-hover shadow-sm border border-secondary-100 rounded-lg bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-600 mb-1">พนักงานในระบบทั้งหมด</p>
                    <p class="text-2xl font-semibold text-secondary-900">{{ number_format($totalEmployees) }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Trend Chart Section (Visual Only for now, based on data) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6 shadow-sm border border-secondary-100 rounded-lg bg-white">
                <h2 class="text-lg font-semibold text-secondary-900 mb-4">แนวโน้มการตรวจวัด 7 วันที่ผ่านมา</h2>
                <div class="relative h-80 w-full">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Device Health Section -->
            <!-- <div class="card p-6 shadow-sm border border-secondary-100 rounded-lg bg-white">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-secondary-900">สถานะอุปกรณ์ (Device Health)</h2>
                <a href="{{ route('devices.index') }}" class="text-sm text-primary-600 hover:text-primary-700">ดูทั้งหมด</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">อุปกรณ์</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">อัพเดตล่าสุด</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-200">
                        @forelse($deviceHealth as $device)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $device->model ?? $device->serial_num }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">{{ $device->ip_address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                                @if($device->lastseen_at)
                                    {{ \Carbon\Carbon::parse($device->lastseen_at)->diffForHumans() }}
                                @else
                                    ไม่พบข้อมูล
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-4 text-center text-sm text-secondary-500">ไม่มีอุปกรณ์ในระบบ</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> -->
        </div>

        <!-- Right Sidebar (Monitoring) -->
        <div class="space-y-6">
            <!-- Recent Infractions -->
            <div class="card p-6 shadow-sm border border-danger-100 rounded-lg bg-white">
                <h3 class="text-lg font-semibold text-danger-600 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    แจ้งเตือนพบแอลกอฮอล์ล่าสุด
                </h3>
                <div class="space-y-4">
                    @forelse($recentInfractions as $infraction)
                        <div class="flex items-start space-x-3 p-3 bg-danger-50 rounded-md">
                            <div class="w-2 h-2 bg-danger-500 rounded-full mt-2 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-secondary-900">
                                    {{ $infraction->employee ? $infraction->employee->first_name . ' ' . $infraction->employee->last_name : 'ไม่ทราบชื่อ' }}
                                </p>
                                <p class="text-sm text-danger-600">ระดับแอลกอฮอล์: {{ $infraction->alcohol_level }} mg%</p>
                                <p class="text-xs text-secondary-500 mt-1">
                                    {{ \Carbon\Carbon::parse($infraction->testing_date)->diffForHumans() }} (อุปกรณ์:
                                    {{ $infraction->device_sn }})</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-500 text-center py-4">ไม่พบการทำผิดกฎล่าสุด</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trendData = @json($last7Days);

            const labels = trendData.map(d => d.label + ' (' + d.date.substring(5) + ')');
            const tests = trendData.map(d => d.tests);
            const fails = trendData.map(d => d.fails);

            const ctx = document.getElementById('trendChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'จำนวนตรวจทั้งหมด',
                            data: tests,
                            backgroundColor: '#3b82f6',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'พบแอลกอฮอล์',
                            data: fails,
                            backgroundColor: '#ef4444',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>