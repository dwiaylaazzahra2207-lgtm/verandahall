<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Register - VerandaHall</title>
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

        .register-container {
            background: #1A3D4D;
            border-radius: 40px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
            transition: box-shadow 0.2s ease;
        }

        .register-container:hover {
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.3);
        }

        .register-header {
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
            margin-bottom: 1.25rem;
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

        .register-button {
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

        .register-button:hover {
            background: #0f7a4a;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .register-button:active {
            transform: translateY(1px);
        }

        .login-link {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #DAECF2;
            font-family: 'Poppins', sans-serif;
        }

        .login-link a {
            color: #F9F3C5;
            font-weight: 700;
            text-decoration: none;
            border-bottom: 1px dotted #F9F3C5;
            transition: all 0.2s;
        }

        .login-link a:hover {
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
            .register-container {
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
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
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

        @if($errors->any())
            <div class="alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Field Nama -->
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="form-input"
                       placeholder="Masukkan nama lengkap"
                       autofocus autocomplete="name">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Field Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-input"
                       placeholder="Masukkan email"
                       autocomplete="username">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Field Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="password-wrapper">
                    <input id="password" type="password" name="password"
                           class="form-input password-input"
                           placeholder="Buat password"
                           autocomplete="new-password">
                    <button type="button" class="toggle-password" id="togglePasswordBtn">
                        <i class="far fa-eye-slash" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Field Konfirmasi Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-input password-input"
                           placeholder="Ulangi password"
                           autocomplete="new-password">
                    <button type="button" class="toggle-password" id="toggleConfirmBtn">
                        <i class="far fa-eye-slash" id="eyeIconConfirm"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="register-button">
                <span>Register</span>
            </button>

            <p class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>

    <script>
        // Toggle password
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeIcon.classList.toggle('fa-eye-slash', type === 'password');
                eyeIcon.classList.toggle('fa-eye', type === 'text');
            });
        }

        // Toggle konfirmasi password
        const confirmInput = document.getElementById('password_confirmation');
        const toggleConfirmBtn = document.getElementById('toggleConfirmBtn');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');

        if (toggleConfirmBtn) {
            toggleConfirmBtn.addEventListener('click', function () {
                const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmInput.setAttribute('type', type);
                eyeIconConfirm.classList.toggle('fa-eye-slash', type === 'password');
                eyeIconConfirm.classList.toggle('fa-eye', type === 'text');
            });
        }
    </script>
</body>
</html>