<x-app-layout>
<div class="mb-8">
                <h1 class="text-3xl font-semibold text-secondary-900 mb-2">ภาพรวมแดชบอร์ด</h1>
                <p class="text-secondary-600">ข้อมูลสรุปและสถิติการใช้งานระบบ</p>
            </div>

            <!-- Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="card p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-secondary-600 mb-1">ผู้ใช้งานทั้งหมด</p>
                            <p class="text-2xl font-semibold text-secondary-900">2,847</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-success-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                </svg>
                                <span class="text-sm text-success-600 font-medium">+12.5%</span>
                                <span class="text-sm text-secondary-500 ml-1">จากเดือนที่แล้ว</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Forms -->
                <div class="card p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-secondary-600 mb-1">ฟอร์มที่ใช้งาน</p>
                            <p class="text-2xl font-semibold text-secondary-900">156</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-success-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                </svg>
                                <span class="text-sm text-success-600 font-medium">+8.2%</span>
                                <span class="text-sm text-secondary-500 ml-1">จากเดือนที่แล้ว</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-accent-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Recent Submissions -->
                <div class="card p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-secondary-600 mb-1">การส่งข้อมูลล่าสุด</p>
                            <p class="text-2xl font-semibold text-secondary-900">1,234</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-warning-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                                <span class="text-sm text-warning-600 font-medium">-2.1%</span>
                                <span class="text-sm text-secondary-500 ml-1">จากเดือนที่แล้ว</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-warning-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="card p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-secondary-600 mb-1">สถานะระบบ</p>
                            <p class="text-2xl font-semibold text-success-600">ปกติ</p>
                            <div class="flex items-center mt-2">
                                <div class="w-2 h-2 bg-success-500 rounded-full mr-2"></div>
                                <span class="text-sm text-secondary-500">อัพเดทล่าสุด: 5 นาทีที่แล้ว</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Chart Section -->
                <div class="lg:col-span-2">
                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-secondary-900">แนวโน้มการใช้งาน</h2>
                            <div class="flex items-center space-x-2">
                                <select class="text-sm border border-secondary-200 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <option>7 วันที่ผ่านมา</option>
                                    <option>30 วันที่ผ่านมา</option>
                                    <option>90 วันที่ผ่านมา</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Chart Placeholder -->
                        <div class="h-80 bg-secondary-50 rounded-lg flex items-center justify-center relative overflow-hidden">
                            <svg class="w-full h-full" viewBox="0 0 800 320" xmlns="http://www.w3.org/2000/svg">
                                <!-- Grid Lines -->
                                <defs>
                                    <pattern id="grid" width="40" height="32" patternUnits="userSpaceOnUse">
                                        <path d="M 40 0 L 0 0 0 32" fill="none" stroke="#e2e8f0" stroke-width="1"/>
                                    </pattern>
                                </defs>
                                <rect width="100%" height="100%" fill="url(#grid)"/>
                                
                                <!-- Chart Line -->
                                <polyline fill="none" stroke="#2563eb" stroke-width="3" points="50,250 120,200 190,180 260,160 330,140 400,120 470,100 540,90 610,85 680,80 750,75"/>
                                
                                <!-- Data Points -->
                                <circle cx="50" cy="250" r="4" fill="#2563eb"/>
                                <circle cx="120" cy="200" r="4" fill="#2563eb"/>
                                <circle cx="190" cy="180" r="4" fill="#2563eb"/>
                                <circle cx="260" cy="160" r="4" fill="#2563eb"/>
                                <circle cx="330" cy="140" r="4" fill="#2563eb"/>
                                <circle cx="400" cy="120" r="4" fill="#2563eb"/>
                                <circle cx="470" cy="100" r="4" fill="#2563eb"/>
                                <circle cx="540" cy="90" r="4" fill="#2563eb"/>
                                <circle cx="610" cy="85" r="4" fill="#2563eb"/>
                                <circle cx="680" cy="80" r="4" fill="#2563eb"/>
                                <circle cx="750" cy="75" r="4" fill="#2563eb"/>
                                
                                <!-- Area Fill -->
                                <polygon fill="url(#gradient)" points="50,250 120,200 190,180 260,160 330,140 400,120 470,100 540,90 610,85 680,80 750,75 750,300 50,300" opacity="0.1"/>
                                
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" style="stop-color:#2563eb;stop-opacity:0.3"/>
                                        <stop offset="100%" style="stop-color:#2563eb;stop-opacity:0"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                            
                            <!-- Chart Labels -->
                            <div class="absolute bottom-4 left-4 right-4 flex justify-between text-xs text-secondary-500">
                                <span>จ</span>
                                <span>อ</span>
                                <span>พ</span>
                                <span>พฤ</span>
                                <span>ศ</span>
                                <span>ส</span>
                                <span>อา</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- Recent Activity -->
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-secondary-900 mb-4">กิจกรรมล่าสุด</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-primary-500 rounded-full mt-2 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-secondary-900">สมชาย ใจดี ส่งฟอร์มใหม่</p>
                                    <p class="text-xs text-secondary-500">5 นาทีที่แล้ว</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-success-500 rounded-full mt-2 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-secondary-900">ระบบอัพเดทเสร็จสิ้น</p>
                                    <p class="text-xs text-secondary-500">15 นาทีที่แล้ว</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-warning-500 rounded-full mt-2 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-secondary-900">มีฟอร์มรอการอนุมัติ 3 รายการ</p>
                                    <p class="text-xs text-secondary-500">30 นาทีที่แล้ว</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-accent-500 rounded-full mt-2 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-secondary-900">สุดา แสงทอง เข้าสู่ระบบ</p>
                                    <p class="text-xs text-secondary-500">1 ชั่วโมงที่แล้ว</p>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="block text-center text-sm text-primary-600 hover:text-primary-700 mt-4 font-medium">
                            ดูกิจกรรมทั้งหมด
                        </a>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-secondary-900 mb-4">การดำเนินการด่วน</h3>
                        <div class="space-y-3">
                            <a href="form_management.html" class="flex items-center space-x-3 p-3 rounded-md hover:bg-secondary-50 transition-colors">
                                <div class="w-8 h-8 bg-primary-100 rounded-md flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-secondary-900">สร้างฟอร์มใหม่</p>
                                    <p class="text-xs text-secondary-500">เพิ่มฟอร์มสำหรับเก็บข้อมูล</p>
                                </div>
                            </a>
                            <a href="data_tables_management.html" class="flex items-center space-x-3 p-3 rounded-md hover:bg-secondary-50 transition-colors">
                                <div class="w-8 h-8 bg-accent-100 rounded-md flex items-center justify-center">
                                    <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-secondary-900">ดูรายงาน</p>
                                    <p class="text-xs text-secondary-500">สรุปข้อมูลและสถิติ</p>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="flex items-center space-x-3 p-3 rounded-md hover:bg-secondary-50 transition-colors">
                                <div class="w-8 h-8 bg-success-100 rounded-md flex items-center justify-center">
                                    <svg class="w-4 h-4 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-secondary-900">อนุมัติรายการ</p>
                                    <p class="text-xs text-secondary-500">ตรวจสอบและอนุมัติ</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
