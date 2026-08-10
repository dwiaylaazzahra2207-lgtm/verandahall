<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Login - VerandaHall</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #E4F7FF;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .login-container {
            background: #1A3D4D;
            border-radius: 40px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
            transition: transform 0.2s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-wrapper {
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
        }

        .logo-image {
            width: 70px;
            height: 70px;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));
            border-radius: 20px;
        }

        .brand-title {
            font-size: 2.2rem;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            color: white;
            letter-spacing: -0.5px;
        }

        .brand-underline {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0px;
            margin-top: 0.5rem;
            width: 100%;
            padding: 0 16px;
        }

        .dot-left {
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            left: 10px;
        }

        .line-middle {
            flex: 1;
            height: 2px;
            background-color: white;
            max-width: 300px;
            margin: 25px 10px;
        }

        .dot-right {
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            right: 10px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #CFE9F2;
            font-family: 'Poppins', sans-serif;
        }

        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1.2rem;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            border: 1px solid #D0E5ED;
            border-radius: 48px;
            background-color: #FFFFFF;
            transition: all 0.25s ease;
            outline: none;
            color: #1F2F38;
        }

        .password-input {
            padding-right: 3.2rem;
        }

        .form-input:focus {
            border-color: #17965E;
            box-shadow: 0 0 0 4px rgba(23, 150, 94, 0.2);
        }

        .form-input::placeholder {
            color: #A1B4BC;
            font-weight: 400;
            font-size: 0.85rem;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8AA9B5;
            font-size: 1.2rem;
            transition: color 0.2s;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            color: #17965E;
        }

        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }

        .forgot-password a {
            font-size: 0.75rem;
            font-family: 'Poppins', sans-serif;
            color: #B9DFF0;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .login-button {
            width: 50%;
            background: #17965E;
            color: white;
            border: none;
            padding: 0.9rem 1rem;
            font-size: 1.2rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            border-radius: 60px;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 0.75rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.1);
            margin-left: auto;
            margin-right: auto;
        }

        .login-button:hover {
            background: #0f7a4a;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .login-button:active {
            transform: translateY(1px);
        }

        .register-link {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #DAECF2;
            font-family: 'Poppins', sans-serif;
        }

        .register-link a {
            color: #F9F3C5;
            font-weight: 700;
            text-decoration: none;
            border-bottom: 1px dotted #F9F3C5;
            transition: all 0.2s;
        }

        .register-link a:hover {
            color: #FFE4A3;
            border-bottom-color: #FFE4A3;
        }

        .error-message {
            color: #FFB4A2;
            font-size: 0.7rem;
            margin-top: 0.4rem;
            margin-left: 0.5rem;
            font-weight: 500;
        }

        /* Alert message styling untuk error login */
        .alert-danger {
            background-color: rgba(248, 215, 218, 0.95);
            color: #721c24;
            padding: 0.75rem 1rem;
            border-radius: 48px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            text-align: center;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem 1.5rem;
                border-radius: 32px;
            }
            .brand-title {
                font-size: 1.9rem;
            }
            .logo-image {
                width: 55px;
                height: 55px;
            }
        }

        .login-container:hover {
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo-wrapper">
                <img class="logo-image" src="{{ asset('images/logo.png') }}" alt="VerandaHall Logo" onerror="this.src='https://placehold.co/200x200/1A3D4D/white?text=VH'">
            </div>
            <h1 class="brand-title">VerandaHall</h1>
            <div class="brand-underline">
                <span class="dot-left"></span>
                <span class="line-middle"></span>
                <span class="dot-right"></span>
            </div>
        </div>

        <!-- Error login -->
        @if($errors->any())
            <div class="alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM LOGIN - Mengarah ke route 'login' POST yang sudah ada di auth.php -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Field Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" 
                       class="form-input" 
                       placeholder="Masukkan email" 
                       autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Field Password dengan fitur mata -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="password-wrapper">
                    <input id="password" type="password" name="password" 
                           class="form-input password-input" 
                           placeholder="Masukkan password">
                    <button type="button" class="toggle-password" id="togglePasswordBtn">
                        <i class="far fa-eye-slash" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Lupa Password?</a>
                </div>
            </div>

            <button type="submit" class="login-button">
                <span>Login</span> 
            </button>

            <p class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </p>
        </form>
    </div>

    <script>
        // ========== TOGGLE PASSWORD (FITUR MATA) ==========
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        }
    </script>
</body>
</html>