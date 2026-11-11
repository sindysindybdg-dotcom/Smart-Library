<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Siswa') - SmartLib</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --accent-blue: #dbeafe;
            --success-green: #10b981;
            --warning-orange: #f59e0b;
            --danger-red: #ef4444;
            --bg-light: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--bg-light); color: var(--text-dark); }

        .top-nav {
            background: white; border-bottom: 1px solid var(--border-color);
            padding: 12px 24px; display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 1000;
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-brand-icon {
            width: 40px; height: 40px; background: var(--primary-blue);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px; overflow: hidden; flex-shrink: 0;
        }
        .nav-brand-icon img { width: 100%; height: 100%; object-fit: contain; }
        .nav-brand-text h1 { font-size: 16px; font-weight: 700; margin: 0; }
        .nav-brand-text small { font-size: 11px; color: var(--text-muted); }

        .nav-search {
            background: var(--bg-light); border: 1px solid var(--border-color);
            border-radius: 8px; padding: 8px 16px; width: 350px;
            display: flex; align-items: center; gap: 8px;
        }
        .nav-search input { border: none; background: transparent; outline: none; width: 100%; font-size: 13px; }

        .nav-menu { display: flex; align-items: center; gap: 8px; }
        .nav-menu a {
            padding: 8px 16px; border-radius: 8px; text-decoration: none;
            color: var(--text-dark); font-size: 13px; font-weight: 500;
            white-space: nowrap;
        }
        .nav-menu a:hover { background: var(--bg-light); }
        .nav-menu a.active { background: var(--primary-blue); color: white; }

        .nav-user { display: flex; align-items: center; gap: 12px; }
        .nav-user-avatar {
            width: 36px; height: 36px; background: var(--primary-blue);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 14px; flex-shrink: 0;
        }
        .nav-user-info .user-name { font-size: 13px; font-weight: 600; }
        .nav-user-info .user-role { font-size: 11px; color: var(--text-muted); }

        .content-area { padding: 24px; max-width: 1400px; margin: 0 auto; }
        .breadcrumb-custom { font-size: 13px; color: var(--text-muted); margin-bottom: 12px; }
        .breadcrumb-custom a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb-custom a:hover { color: var(--primary-blue); }

        .card-custom { background: white; border-radius: 12px; border: 1px solid var(--border-color); padding: 24px; margin-bottom: 20px; }
        .card-title { font-size: 16px; font-weight: 700; margin-bottom: 16px; }

        .btn-primary-custom {
            background: var(--primary-blue); color: white; border: none; border-radius: 8px;
            padding: 10px 20px; font-size: 13px; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary-custom:hover { background: #1e3a8a; color: white; }
        .btn-outline-custom {
            background: white; color: var(--text-dark); border: 1px solid var(--border-color);
            border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 500;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-outline-custom:hover { background: var(--bg-light); }

        .footer-custom { background: white; border-top: 1px solid var(--border-color); padding: 40px 24px 20px; margin-top: 40px; }

        /* ======================================== */
        /* 📱 MOBILE MENU & HAMBURGER */
        /* ======================================== */
        .hamburger-menu {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--primary-blue);
            cursor: pointer;
            padding: 4px;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 65px;
            left: 0;
            right: 0;
            background: white;
            padding: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            z-index: 999;
            border-bottom: 2px solid var(--border-color);
        }
        .mobile-menu.show { display: block; }
        .mobile-menu a {
            display: block;
            padding: 12px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            margin-bottom: 4px;
        }
        .mobile-menu a.active { background: var(--primary-blue); color: white; }
        .mobile-menu .search-mobile {
            margin-bottom: 12px;
        }

        /* ======================================== */
        /* 📱 RESPONSIVE - TABLET (max-width: 992px) */
        /* ======================================== */
        @media (max-width: 992px) {
            .nav-search { width: 200px; }
            .nav-menu a { padding: 6px 12px; font-size: 12px; }
            .content-area { padding: 16px; }
        }

        /* ======================================== */
        /* 📱 RESPONSIVE - MOBILE (max-width: 768px) */
        /* ======================================== */
        @media (max-width: 768px) {
            .top-nav { padding: 10px 16px; }
            
            /* Hide desktop menu & search */
            .nav-menu, .nav-search { display: none; }
            
            /* Show hamburger */
            .hamburger-menu { display: block; }
            
            /* Brand lebih compact */
            .nav-brand-icon { width: 36px; height: 36px; font-size: 18px; }
            .nav-brand-text h1 { font-size: 14px; }
            .nav-brand-text small { display: none; }
            
            /* User info lebih simple */
            .nav-user-info { display: none !important; }
            .nav-user-avatar { width: 32px; height: 32px; font-size: 12px; }
            
            /* Content padding */
            .content-area { padding: 12px; }
            
            /* Card padding lebih kecil */
            .card-custom { padding: 16px; }
            
            /* Footer */
            .footer-custom { padding: 24px 16px 16px; margin-top: 24px; }
            .footer-custom .col-md-3 { margin-bottom: 24px; }
        }

        /* ======================================== */
        /* 📱 RESPONSIVE - SMALL MOBILE (max-width: 576px) */
        /* ======================================== */
        @media (max-width: 576px) {
            .nav-brand-text h1 { font-size: 13px; }
            .btn-primary-custom, .btn-outline-custom {
                font-size: 12px;
                padding: 8px 16px;
            }
            .card-title { font-size: 14px; }
        }

        /* ======================================== */
        /* 📱 RESPONSIVE - EXTRA SMALL (max-width: 480px) */
        /* ======================================== */
        @media (max-width: 480px) {
            .nav-user { gap: 8px; }
            .nav-user-avatar { display: none; }
            .btn-light { padding: 6px !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

    @php
        $logoSekolah = \App\Models\Setting::get('logo');
    @endphp

    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-brand">
            @if($logoSekolah)
                <div class="nav-brand-icon" style="background: white; border: 1px solid var(--border-color); padding: 4px;">
                    <img src="{{ asset('storage/' . $logoSekolah) }}" alt="Logo Sekolah">
                </div>
            @else
                <div class="nav-brand-icon"><i class="bi bi-book-half"></i></div>
            @endif
            <div class="nav-brand-text">
                <h1>SmartLib</h1>
                <small>SMK Budi Bakti Ciwidey</small>
            </div>
        </div>

        <!-- Search Desktop -->
        <div class="nav-search d-none d-md-flex">
            <i class="bi bi-search" style="color: var(--text-muted);"></i>
            <input type="text" placeholder="Cari judul buku, penulis, ISBN...">
        </div>

        <!-- Desktop Menu -->
        <div class="nav-menu d-none d-lg-flex">
            <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Katalog
            </a>
            <a href="{{ route('siswa.riwayat') }}" class="{{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
            <a href="{{ route('siswa.profil') }}" class="{{ request()->routeIs('siswa.profil') ? 'active' : '' }}">
                <i class="bi bi-person"></i> Profil
            </a>
        </div>

        <div class="nav-user">
            <button class="btn btn-light btn-sm position-relative d-none d-sm-flex">
                <i class="bi bi-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 8px;">1</span>
            </button>
            <div class="nav-user-avatar">{{ strtoupper(substr(Auth::user()->nama ?? 'S', 0, 1)) }}</div>
            <div class="nav-user-info d-none d-md-block">
                <div class="user-name">{{ Auth::user()->nama ?? 'Siswa' }}</div>
                <div class="user-role">Siswa Aktif</div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" style="margin-left: 8px;">
                @csrf
                <button type="submit" class="btn btn-light btn-sm" title="Logout" style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; padding: 0;">
                    <i class="bi bi-box-arrow-right" style="font-size: 14px; color: var(--text-muted);"></i>
                </button>
            </form>

            <!-- Hamburger Button -->
            <button class="hamburger-menu" onclick="toggleMobileMenu()">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="search-mobile">
            <div class="nav-search" style="width: 100%;">
                <i class="bi bi-search" style="color: var(--text-muted);"></i>
                <input type="text" placeholder="Cari judul buku...">
            </div>
        </div>
        <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <i class="bi bi-book me-2"></i> Katalog Buku
        </a>
        <a href="{{ route('siswa.riwayat') }}" class="{{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
            <i class="bi bi-clock-history me-2"></i> Riwayat Peminjaman
        </a>
        <a href="{{ route('siswa.profil') }}" class="{{ request()->routeIs('siswa.profil') ? 'active' : '' }}">
            <i class="bi bi-person me-2"></i> Profil Saya
        </a>
        <a href="{{ route('publik.beranda') }}">
            <i class="bi bi-house me-2"></i> Beranda Publik
        </a>
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>

    <!-- Content Area -->
    <div class="content-area">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="row g-4">
            <div class="col-12 col-md-3">
                <div class="d-flex align-items-center gap-2 mb-3">
                    @if($logoSekolah)
                        <div class="nav-brand-icon" style="width: 32px; height: 32px; font-size: 16px; background: white; border: 1px solid var(--border-color); padding: 2px;">
                            <img src="{{ asset('storage/' . $logoSekolah) }}" alt="Logo Sekolah">
                        </div>
                    @else
                        <div class="nav-brand-icon" style="width: 32px; height: 32px; font-size: 16px;"><i class="bi bi-book-half"></i></div>
                    @endif
                    <strong>SmartLib</strong>
                </div>
                <small class="text-muted">Layanan perpustakaan digital terpadu SMK Budi Bakti Ciwidey.</small>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="fw-bold">Tautan Siswa</h6>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2"><a href="{{ route('siswa.dashboard') }}" class="text-decoration-none text-muted">Katalog Buku</a></li>
                    <li class="mb-2"><a href="{{ route('siswa.riwayat') }}" class="text-decoration-none text-muted">Riwayat Pinjam</a></li>
                    <li class="mb-2"><a href="{{ route('siswa.profil') }}" class="text-decoration-none text-muted">Profil Saya</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="fw-bold">Jam Operasional</h6>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2">Senin - Kamis: 07.30 - 15.30</li>
                    <li class="mb-2">Jumat: 07.30 - 11.30</li>
                    <li>Sabtu - Minggu: Tutup</li>
                </ul>
            </div>
            <div class="col-12 col-md-3">
                <h6 class="fw-bold">Kontak</h6>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2">Jl. Babakan Tiga No.82, Ciwidey</li>
                    <li class="mb-2">perpus@smkbudibakti.sch.id</li>
                    <li>WhatsApp: +62 821-1234-5678</li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center small text-muted">
            <span>© 2025 Smart Library - SMK Budi Bakti Ciwidey</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('show');
        }
        
        // Tutup menu saat klik di luar
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const hamburger = document.querySelector('.hamburger-menu');
            if (!menu.contains(event.target) && !hamburger.contains(event.target)) {
                menu.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>