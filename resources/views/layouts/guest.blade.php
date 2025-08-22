


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>เข้าสู่ระบบ - Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<script type="module" src="https://static.rocket.new/rocket-web.js?_cfg=https%3A%2F%2Fadmindash5340back.builtwithrocket.new&_be=https%3A%2F%2Fapplication.rocket.new&_v=0.1.6"></script>
</head>
<head>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center p-4">
    <!-- Background Pattern -->

{{ $slot }}
    <!-- JavaScript -->
    <!-- <script>
        // Mock user credentials
        const mockUsers = {
            'admin@company.com': { password: 'admin123', role: 'admin', name: 'ผู้ดูแลระบบ' },
            'user@company.com': { password: 'user123', role: 'user', name: 'ผู้ใช้งาน' },
            'manager@company.com': { password: 'manager123', role: 'manager', name: 'ผู้จัดการ' }
        };

        // DOM Elements
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginButton = document.getElementById('loginButton');
        const loginText = document.getElementById('loginText');
        const loginSpinner = document.getElementById('loginSpinner');
        const loginError = document.getElementById('loginError');
        const loginErrorMessage = document.getElementById('loginErrorMessage');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const togglePassword = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        // Password toggle functionality
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        });

        // Input validation
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function showError(element, show) {
            if (show) {
                element.classList.remove('hidden');
                element.previousElementSibling.classList.add('border-error-500', 'focus:border-error-500', 'focus:ring-error-500');
                element.previousElementSibling.classList.remove('border-slate-200', 'focus:border-primary-500', 'focus:ring-primary-500');
            } else {
                element.classList.add('hidden');
                element.previousElementSibling.classList.remove('border-error-500', 'focus:border-error-500', 'focus:ring-error-500');
                element.previousElementSibling.classList.add('border-slate-200', 'focus:border-primary-500', 'focus:ring-primary-500');
            }
        }

        function showLoginError(message) {
            loginErrorMessage.textContent = message;
            loginError.classList.remove('hidden');
        }

        function hideLoginError() {
            loginError.classList.add('hidden');
        }

        // Real-time validation
        emailInput.addEventListener('blur', function() {
            const isValid = validateEmail(this.value);
            showError(emailError, !isValid && this.value !== '');
        });

        emailInput.addEventListener('input', function() {
            if (!emailError.classList.contains('hidden')) {
                const isValid = validateEmail(this.value);
                showError(emailError, !isValid);
            }
            hideLoginError();
        });

        passwordInput.addEventListener('input', function() {
            if (!passwordError.classList.contains('hidden')) {
                showError(passwordError, this.value === '');
            }
            hideLoginError();
        });

        // Form submission
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = emailInput.value.trim();
            const password = passwordInput.value;
            
            // Reset errors
            hideLoginError();
            showError(emailError, false);
            showError(passwordError, false);
            
            // Validate inputs
            let hasError = false;
            
            if (!email) {
                showError(emailError, true);
                emailError.textContent = 'กรุณากรอกอีเมล';
                hasError = true;
            } else if (!validateEmail(email)) {
                showError(emailError, true);
                emailError.textContent = 'กรุณากรอกอีเมลที่ถูกต้อง';
                hasError = true;
            }
            
            if (!password) {
                showError(passwordError, true);
                passwordError.textContent = 'กรุณากรอกรหัสผ่าน';
                hasError = true;
            }
            
            if (hasError) return;
            
            // Show loading state
            loginButton.disabled = true;
            loginText.classList.add('invisible');
            loginSpinner.classList.remove('hidden');
            
            // Simulate authentication delay
            setTimeout(() => {
                const user = mockUsers[email];
                
                if (user && user.password === password) {
                    // Success - store user data and redirect
                    localStorage.setItem('currentUser', JSON.stringify({
                        email: email,
                        name: user.name,
                        role: user.role,
                        loginTime: new Date().toISOString()
                    }));
                    
                    // Redirect to dashboard
                    window.location.href = 'dashboard_overview.html';
                } else {
                    // Failed authentication
                    showLoginError('อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
                    
                    // Reset loading state
                    loginButton.disabled = false;
                    loginText.classList.remove('invisible');
                    loginSpinner.classList.add('hidden');
                }
            }, 1500);
        });

        // Auto-fill demo credentials on click
        document.querySelectorAll('[data-email]').forEach(element => {
            element.addEventListener('click', function() {
                const email = this.getAttribute('data-email');
                const password = this.getAttribute('data-password');
                emailInput.value = email;
                passwordInput.value = password;
                hideLoginError();
                showError(emailError, false);
                showError(passwordError, false);
            });
        });

        // Check if user is already logged in
        if (localStorage.getItem('currentUser')) {
            // window.location.href = 'dashboard_overview.html';
        }
    </script> -->
<!-- <script id="dhws-dataInjector" src="../public/dhws-data-injector.js"></script> -->
</body>
</html>
