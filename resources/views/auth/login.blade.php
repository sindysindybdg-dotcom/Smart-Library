<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Library SMK Budi Bakti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-wrapper {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.25);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-left {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 60px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        .login-content { position: relative; z-index: 1; }
        .brand-logo {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            margin-bottom: 24px;
            transition: transform 0.3s;
        }
        .brand-logo:hover { transform: rotate(5deg) scale(1.05); }
        .brand-title { font-size: 32px; font-weight: 800; margin: 0 0 8px 0; letter-spacing: -0.5px; }
        .brand-subtitle { font-size: 14px; opacity: 0.9; margin-bottom: 32px; }
        .feature-list { list-style: none; padding: 0; margin: 0; }
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 20px;
            padding: 16px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
        }
        .feature-item:hover {
            background: rgba(255,255,255,0.15);
            transform: translateX(8px);
        }
        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .feature-text h3 { font-size: 15px; font-weight: 700; margin: 0 0 4px 0; }
        .feature-text p { font-size: 13px; opacity: 0.9; margin: 0; line-height: 1.5; }
        .login-right { padding: 60px 40px; }
        .login-header { margin-bottom: 32px; }
        .login-header h2 { font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0; }
        .login-header p { color: #64748b; margin: 0; font-size: 15px; }
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            display: block;
        }
        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }
        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
            transition: color 0.2s;
            z-index: 2;
        }
        .form-control-custom {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .form-control-custom:focus + i { color: #3b82f6; }
        .btn-login {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-login:hover::before { left: 100%; }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 64, 175, 0.4);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        .footer-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }
        .footer-link small {
            color: #64748b;
            font-size: 14px;
        }
        .footer-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s;
        }
        .footer-link a:hover { color: #1e40af; text-decoration: underline; }
        @media (max-width: 992px) {
            .login-wrapper { max-width: 500px; }
            .login-left { display: none; }
            .login-right { padding: 40px 32px; }
        }
        @media (max-width: 576px) {
            .login-right { padding: 32px 24px; }
            .login-header h2 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="row g-0">
            <!-- Left Panel - Branding -->
            <div class="col-lg-6 login-left">
                <div class="login-content">
                    <div class="brand-logo">
                        <i class="bi bi-book-half" style="font-size: 32px;"></i>
                    </div>
                    <h1 class="brand-title">SmartLib</h1>
                    <p class="brand-subtitle">SMK Budi Bakti Ciwidey</p>
                    
                    <ul class="feature-list">
                        <li class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-clock" style="font-size: 20px;"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Akses Katalog 24/7</h3>
                                <p>Jelajahi ribuan koleksi buku kapan saja, di mana saja</p>
                            </div>
                        </li>
                        <li class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-bell" style="font-size: 20px;"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Notifikasi Otomatis</h3>
                                <p>Pengingat pengembalian buku via WhatsApp & Email</p>
                            </div>
                        </li>
                        <li class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up" style="font-size: 20px;"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Laporan Real-time</h3>
                                <p>Monitoring peminjaman dan statistik lengkap</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="col-lg-6 login-right">
                <div class="login-header">
                    <h2>Selamat Datang</h2>
                    <p>Silakan masuk ke akun Anda untuk melanjutkan</p>
                </div>

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 13px; border-radius: 8px;">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 10px;"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 13px; border-radius: 8px;">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 10px;"></button>
                </div>
                @endif

                <form method="POST" action="{{ route('login.action') }}" id="loginForm">
                    @csrf
                    <div class="input-group-custom">
                        <input type="text" name="username" id="username" class="form-control-custom" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                        <i class="bi bi-person"></i>
                    </div>
                    
                    <div class="input-group-custom">
                        <input type="password" name="password" id="password" class="form-control-custom" placeholder="Masukkan kata sandi" required>
                        <i class="bi bi-lock"></i>
                    </div>

                    <button type="submit" class="btn-login" id="btnSubmit">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Sistem
                    </button>
                </form>

                <div class="footer-link">
                    <small>Belum punya akun? <a href="{{ route('register') }}">Daftar Anggota Sekarang</a></small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi input focus
        document.querySelectorAll('.form-control-custom').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>