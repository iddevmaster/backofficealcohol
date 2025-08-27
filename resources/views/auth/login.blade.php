<x-guest-layout>
    <!-- Session Status -->


    
      
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#grid)"/>
        </svg>
    </div>

    <!-- Login Container -->
    <div class="relative w-full max-w-md">
        <!-- Company Logo/Branding -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-slate-900 mb-2">ระบบจัดการผู้ดูแล</h1>
            <p class="text-slate-600">เข้าสู่ระบบเพื่อจัดการข้อมูลองค์กร</p>
        </div>

        <!-- Login Card -->
        <div class="card p-8 shadow-xl border-0">
            <!-- Login Form -->
            <form class="space-y-6"  method="POST" action="{{ route('login') }}">
               @csrf
                <!-- Email Field -->
                <div>
                    <label for="text" class="block text-sm font-medium text-slate-700 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <input type="text" id="username" name="username" class="input-field pl-10 pr-4" placeholder="กรอกชื่อของคุณ" required autofocus />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                    </div>
               @error('username') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>

                <!-- <input id="username" name="username" type="text" required autofocus autocomplete="username">
@error('username') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror -->

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                        รหัสผ่าน
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" class="input-field pl-10 pr-12" placeholder="กรอกรหัสผ่านของคุณ" required autocomplete="current-password" />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none">
                            <svg id="eyeIcon" class="h-5 w-5 text-slate-400 hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <div id="passwordError" class="hidden mt-1 text-sm text-error-600">
                        กรุณากรอกรหัสผ่าน
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary-500 border-slate-300 rounded" />
                        <label for="remember" class="ml-2 block text-sm text-slate-700">
                            จดจำการเข้าสู่ระบบ
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="javascript:void(0)" class="font-medium text-primary hover:text-primary-700 transition-colors duration-150">
                            ลืมรหัสผ่าน?
                        </a>
                    </div>
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit" id="loginButton" class="w-full btn-primary py-3 text-base font-medium relative overflow-hidden">
                        <span id="loginText">เข้าสู่ระบบ</span>
                        <div id="loginSpinner" class="hidden absolute inset-0 flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                        </div>
                    </button>
                </div>

                <!-- Error Message -->
                <div id="loginError" class="hidden p-3 bg-error-50 border border-error-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-error-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-error-800" id="loginErrorMessage">
                                อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง
                            </p>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-8 p-4 bg-slate-50 rounded-lg border border-slate-200">
                <h3 class="text-sm font-medium text-slate-700 mb-2">ข้อมูลทดสอบ:</h3>
                <div class="space-y-1 text-xs text-slate-600">
                    <p><strong>Admin:</strong> admin@gmail.com / 12345678</p>
                    <p><strong>staff:</strong> editor@gmail.com / 12345678</p>
                    <p><strong>User:</strong> user@gmail.com / 12345678</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-sm text-slate-500">
            <p>© 2025 บริษัท ระบบจัดการข้อมูล จำกัด สงวนลิขสิทธิ์</p>
        </div>
    </div>
   

</x-guest-layout>
 


