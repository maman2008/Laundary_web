<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Laundry_HR</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #dbeafe;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            color: var(--gray-800);
        }
        
        .register-container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .register-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .register-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .register-header p {
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .register-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-700);
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: var(--gray-200);
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }
        
        .password-strength.weak .password-strength-bar {
            width: 33%;
            background: var(--error);
        }
        
        .password-strength.medium .password-strength-bar {
            width: 66%;
            background: var(--warning);
        }
        
        .password-strength.strong .password-strength-bar {
            width: 100%;
            background: var(--success);
        }
        
        .password-requirements {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: var(--gray-500);
        }
        
        .error-message {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .success-message {
            color: var(--success);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .btn-primary {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.875rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-200);
            color: var(--gray-600);
            font-size: 0.875rem;
        }
        
        .register-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-footer a:hover {
            text-decoration: underline;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .terms-agreement {
            display: flex;
            align-items: flex-start;
            margin: 1.5rem 0;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 8px;
        }
        
        .terms-agreement input {
            margin-right: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .terms-agreement label {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.4;
        }
        
        .terms-agreement a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .terms-agreement a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .register-container {
                border-radius: 12px;
            }
            
            .register-header, .register-body {
                padding: 1.5rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Buat Akun Baru</h1>
            <p>Bergabung dengan Laundry_HR</p>
        </div>
        
        <div class="register-body">
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @if ($errors->has('name'))
                        <div class="error-message">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input id="username" class="form-input" type="text" name="username" value="{{ old('username') }}" required autocomplete="username">
                    @if ($errors->has('username'))
                        <div class="error-message">
                            {{ $errors->first('username') }}
                        </div>
                    @endif
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @if ($errors->has('email'))
                        <div class="error-message">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password">
                    <div class="password-strength" id="passwordStrength">
                        <div class="password-strength-bar"></div>
                    </div>
                    <div class="password-requirements">
                        Minimal 8 karakter, mengandung huruf dan angka
                    </div>
                    @if ($errors->has('password'))
                        <div class="error-message">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password">
                    <div id="passwordMatch" class="success-message" style="display: none;">
                        ✓ Kata sandi cocok
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="error-message">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <!-- Terms Agreement -->
                <div class="terms-agreement">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Saya menyetujui <a href="#">Syarat dan Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> Laundry_HR
                    </label>
                </div>

                <button type="submit" class="btn-primary">
                    Daftar Sekarang
                </button>
            </form>
            
            <div class="register-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordConfirm = document.getElementById('password_confirmation');
        const passwordMatch = document.getElementById('passwordMatch');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength++;
            
            // Contains both letters and numbers
            if (/[a-zA-Z]/.test(password) && /[0-9]/.test(password)) strength++;
            
            // Contains special characters
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            // Update strength indicator
            passwordStrength.className = 'password-strength';
            if (password.length > 0) {
                if (strength === 1) {
                    passwordStrength.classList.add('weak');
                } else if (strength === 2) {
                    passwordStrength.classList.add('medium');
                } else if (strength >= 3) {
                    passwordStrength.classList.add('strong');
                }
            }
        });
        
        // Password confirmation check
        passwordConfirm.addEventListener('input', function() {
            if (this.value && passwordInput.value) {
                if (this.value === passwordInput.value) {
                    passwordMatch.style.display = 'block';
                    passwordMatch.className = 'success-message';
                    passwordMatch.textContent = '✓ Kata sandi cocok';
                } else {
                    passwordMatch.style.display = 'block';
                    passwordMatch.className = 'error-message';
                    passwordMatch.textContent = '✗ Kata sandi tidak cocok';
                }
            } else {
                passwordMatch.style.display = 'none';
            }
        });
        
        // Form submission validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = passwordConfirm.value;
            const terms = document.getElementById('terms').checked;
            
            if (!terms) {
                e.preventDefault();
                alert('Anda harus menyetujui Syarat dan Ketentuan untuk melanjutkan.');
                return;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Kata sandi dan konfirmasi kata sandi tidak cocok.');
                return;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Kata sandi harus minimal 8 karakter.');
                return;
            }
        });
    </script>
</body>
</html>