<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Anggota Baru - SMK Budi Bakti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8eeff 50%, #f5f3ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.08);
        }
        .logo-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
        }
        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0f4ff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            color: #2563eb;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }
        .logo-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #2563eb;
            border-radius: 50%;
        }
        .register-title {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            text-align: center;
            margin-bottom: 8px;
        }
        .register-subtitle {
            font-size: 13px;
            color: #64748b;
            text-align: center;
            margin-bottom: 24px;
        }
        .role-tabs {
            display: flex;
            background: #f1f5f9;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 24px;
        }
        .role-tab {
            flex: 1;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .role-tab.active {
            background: white;
            color: #2563eb;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .input-wrapper {
            position: relative;
            margin-bottom: 16px;
        }
        .input-wrapper i.input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }
        .form-control-custom {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .form-control-custom.is-invalid {
            border-color: #dc2626;
            background: #fef2f2;
        }
        .invalid-feedback {
            font-size: 11px;
            color: #dc2626;
            margin-top: -12px;
            margin-bottom: 12px;
        }
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 16px;
        }
        .form-check-custom {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #475569;
        }
        .form-check-custom input {
            margin-top: 2px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        .btn-register {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #64748b;
        }
        .login-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover { color: #1e40af; }
        .alert-custom {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        .alert-danger-custom {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <!-- Logo -->
        <div class="logo-brand">
            <div class="logo-icon">
                <i class="bi bi-book-half"></i>
            </div>
        </div>
        <div class="text-center">
            <div class="logo-badge">SMK BUDI BAKTI</div>
        </div>

        <!-- Title -->
        <h2 class="register-title">Registrasi Anggota Baru</h2>
        <p class="register-subtitle">Daftarkan diri Anda sebagai anggota perpustakaan (Siswa / Guru)</p>

        @if($errors->any())
        <div class="alert-custom alert-danger-custom">
            <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}
        </div>
        @endif

        <!-- Role Tabs -->
        <div class="role-tabs">
            <button type="button" class="role-tab active" id="tabSiswa" onclick="switchTab('siswa')">
                <i class="bi bi-mortarboard"></i> Siswa
            </button>
            <button type="button" class="role-tab" id="tabGuru" onclick="switchTab('guru')">
                <i class="bi bi-briefcase"></i> Guru / Tendik
            </button>
        </div>

        <!-- Register Form -->
        <form action="{{ route('register.action') }}" method="POST" id="registerForm">
            @csrf
            <input type="hidden" name="tipe_anggota" id="tipeAnggota" value="siswa">

            <!-- NISN / NIP -->
            <label class="form-label" id="labelNomor">NISN / Nomor Induk Siswa</label>
            <div class="input-wrapper">
                <i class="bi bi-hash input-icon"></i>
                <input type="text" name="nomor_induk" class="form-control-custom @error('nomor_induk') is-invalid @enderror" placeholder="Contoh: 0052348912" value="{{ old('nomor_induk') }}" required>
                @error('nomor_induk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <!-- Nama Lengkap -->
            <label class="form-label">Nama Lengkap</label>
            <div class="input-wrapper">
                <i class="bi bi-person input-icon"></i>
                <input type="text" name="nama" class="form-control-custom @error('nama') is-invalid @enderror" placeholder="Nama lengkap sesuai data sekolah" value="{{ old('nama') }}" required>
                @error('nama') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <!-- Kelas / Jabatan -->
            <label class="form-label" id="labelKelas">Kelas & Program Keahlian</label>
            <div class="input-wrapper">
                <i class="bi bi-bookmark input-icon"></i>
                <select name="kelas" class="form-control-custom @error('kelas') is-invalid @enderror" required>
                    <option value="">Pilih rombongan belajar</option>
                    <option value="X PPLG 1" {{ old('kelas') == 'X PPLG 1' ? 'selected' : '' }}>X PPLG 1</option>
                    <option value="X PPLG 2" {{ old('kelas') == 'X PPLG 2' ? 'selected' : '' }}>X PPLG 2</option>
                    <option value="XI PPLG 1" {{ old('kelas') == 'XI PPLG 1' ? 'selected' : '' }}>XI PPLG 1</option>
                    <option value="XII PPLG 1" {{ old('kelas') == 'XII PPLG 1' ? 'selected' : '' }}>XII PPLG 1</option>
                    <option value="X TKJ 1" {{ old('kelas') == 'X TKJ 1' ? 'selected' : '' }}>X TKJ 1</option>
                    <option value="XI TKJ 1" {{ old('kelas') == 'XI TKJ 1' ? 'selected' : '' }}>XI TKJ 1</option>
                    <option value="XII TKJ 1" {{ old('kelas') == 'XII TKJ 1' ? 'selected' : '' }}>XII TKJ 1</option>
                    <option value="X TBSM 1" {{ old('kelas') == 'X TBSM 1' ? 'selected' : '' }}>X TBSM 1</option>
                    <option value="XI TBSM 1" {{ old('kelas') == 'XI TBSM 1' ? 'selected' : '' }}>XI TBSM 1</option>
                    <option value="XII TBSM 1" {{ old('kelas') == 'XII TBSM 1' ? 'selected' : '' }}>XII TBSM 1</option>
                    <option value="X AKL 1" {{ old('kelas') == 'X AKL 1' ? 'selected' : '' }}>X AKL 1</option>
                    <option value="XI AKL 1" {{ old('kelas') == 'XI AKL 1' ? 'selected' : '' }}>XI AKL 1</option>
                    <option value="XII AKL 1" {{ old('kelas') == 'XII AKL 1' ? 'selected' : '' }}>XII AKL 1</option>
                    <option value="X OTPK 1" {{ old('kelas') == 'X OTPK 1' ? 'selected' : '' }}>X OTPK 1</option>
                    <option value="XI OTPK 1" {{ old('kelas') == 'XI OTPK 1' ? 'selected' : '' }}>XI OTPK 1</option>
                    <option value="XII OTPK 1" {{ old('kelas') == 'XII OTPK 1' ? 'selected' : '' }}>XII OTPK 1</option>
                </select>
                @error('kelas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <!-- WhatsApp -->
            <label class="form-label">Nomor WhatsApp / Kontak Aktif</label>
            <div class="input-wrapper">
                <i class="bi bi-telephone input-icon"></i>
                <input type="text" name="whatsapp" class="form-control-custom @error('whatsapp') is-invalid @enderror" placeholder="08xxxxxxxxxx (untuk notifikasi peminjaman)" value="{{ old('whatsapp') }}" required>
                @error('whatsapp') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <label class="form-label">Email Aktif</label>
            <div class="input-wrapper">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" name="email" class="form-control-custom @error('email') is-invalid @enderror" placeholder="nama@smkbudibakti.sch.id" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <!-- Password Row -->
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control-custom @error('password') is-invalid @enderror" placeholder="Min. 8 karakter" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', 'eye1')">
                            <i class="bi bi-eye" id="eye1"></i>
                        </button>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Sandi</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirm" class="form-control-custom" placeholder="Ulangi sandi" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirm', 'eye2')">
                            <i class="bi bi-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Agreement -->
            <div class="form-check-custom">
                <input type="checkbox" name="agree" id="agree" required {{ old('agree') ? 'checked' : '' }}>
                <label for="agree">Saya menyetujui tata tertib dan aturan peminjaman buku Smart Library SMK Budi Bakti.</label>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus"></i> Daftar Anggota Sekarang
            </button>
        </form>

        <!-- Login Link -->
        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>

    <script>
        function switchTab(role) {
            document.getElementById('tabSiswa').classList.remove('active');
            document.getElementById('tabGuru').classList.remove('active');
            document.getElementById('tipeAnggota').value = role;

            const labelNomor = document.getElementById('labelNomor');
            const labelKelas = document.getElementById('labelKelas');
            const inputNomor = document.querySelector('input[name="nomor_induk"]');
            const selectKelas = document.querySelector('select[name="kelas"]');

            if (role === 'siswa') {
                document.getElementById('tabSiswa').classList.add('active');
                labelNomor.textContent = 'NISN / Nomor Induk Siswa';
                inputNomor.placeholder = 'Contoh: 0052348912';
                labelKelas.textContent = 'Kelas & Program Keahlian';
                selectKelas.innerHTML = `
                    <option value="">Pilih rombongan belajar</option>
                    <option value="X PPLG 1">X PPLG 1</option>
                    <option value="X PPLG 2">X PPLG 2</option>
                    <option value="XI PPLG 1">XI PPLG 1</option>
                    <option value="XII PPLG 1">XII PPLG 1</option>
                    <option value="X TKJ 1">X TKJ 1</option>
                    <option value="XI TKJ 1">XI TKJ 1</option>
                    <option value="XII TKJ 1">XII TKJ 1</option>
                    <option value="X TBSM 1">X TBSM 1</option>
                    <option value="XI TBSM 1">XI TBSM 1</option>
                    <option value="XII TBSM 1">XII TBSM 1</option>
                    <option value="X AKL 1">X AKL 1</option>
                    <option value="XI AKL 1">XI AKL 1</option>
                    <option value="XII AKL 1">XII AKL 1</option>
                    <option value="X OTPK 1">X OTPK 1</option>
                    <option value="XI OTPK 1">XI OTPK 1</option>
                    <option value="XII OTPK 1">XII OTPK 1</option>
                `;
            } else {
                document.getElementById('tabGuru').classList.add('active');
                labelNomor.textContent = 'NIP / Nomor Induk Pegawai';
                inputNomor.placeholder = 'Contoh: 198501012010011001';
                labelKelas.textContent = 'Jabatan / Mata Pelajaran';
                selectKelas.innerHTML = `
                    <option value="">Pilih jabatan</option>
                    <option value="Guru Produktif">Guru Produktif</option>
                    <option value="Guru Normatif">Guru Normatif</option>
                    <option value="Guru Adaptif">Guru Adaptif</option>
                    <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                    <option value="Staf Tata Usaha">Staf Tata Usaha</option>
                    <option value="Laboran">Laboran</option>
                    <option value="Pustakawan">Pustakawan</option>
                `;
            }
        }

        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>