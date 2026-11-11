<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Library') - SMK Budi Bakti Ciwidey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --accent-blue: #dbeafe;
            --bg-light: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--bg-light); color: var(--text-dark); }

        /* Navbar Publik */
        .navbar-publik {
            background: white; border-bottom: 1px solid var(--border-color);
            padding: 12px 0; position: sticky; top: 0; z-index: 1000;
        }
        .navbar-brand-custom { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .navbar-brand-icon {
            width: 40px; height: 40px; background: var(--primary-blue);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px; overflow: hidden; flex-shrink: 0;
        }
        .navbar-brand-icon img { width: 100%; height: 100%; object-fit: contain; }
        .navbar-brand-text h1 { font-size: 16px; font-weight: 700; color: var(--primary-blue); margin: 0; }
        .navbar-brand-text small { font-size: 11px; color: var(--text-muted); }

        .nav-menu-publik { display: flex; align-items: center; gap: 8px; }
        .nav-menu-publik a {
            padding: 8px 16px; border-radius: 8px; text-decoration: none;
            color: var(--text-dark); font-size: 13px; font-weight: 500;
            white-space: nowrap;
        }
        .nav-menu-publik a:hover { background: var(--bg-light); }
        .nav-menu-publik a.active { background: var(--primary-blue); color: white; }

        .search-box-publik {
            background: var(--bg-light); border: 1px solid var(--border-color);
            border-radius: 8px; padding: 8px 16px; width: 280px;
            display: flex; align-items: center; gap: 8px;
        }
        .search-box-publik input { border: none; background: transparent; outline: none; width: 100%; font-size: 13px; }

        .btn-masuk { background: white; color: var(--primary-blue); border: 1px solid var(--primary-blue); border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 600; text-decoration: none; white-space: nowrap; }
        .btn-masuk:hover { background: var(--accent-blue); color: var(--primary-blue); }
        .btn-daftar { background: var(--primary-blue); color: white; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 600; text-decoration: none; white-space: nowrap; }
        .btn-daftar:hover { background: var(--primary-light); color: white; }

        /* Footer Publik */
        .footer-publik { background: white; border-top: 1px solid var(--border-color); padding: 40px 0 20px; margin-top: 60px; }
        .footer-publik h6 { font-size: 14px; font-weight: 700; margin-bottom: 16px; }
        .footer-publik a { color: var(--text-muted); text-decoration: none; font-size: 13px; }
        .footer-publik a:hover { color: var(--primary-blue); }
        .footer-publik .footer-desc { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

        /* Breadcrumb */
        .breadcrumb-publik { font-size: 13px; color: var(--text-muted); margin-bottom: 16px; }
        .breadcrumb-publik a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb-publik a:hover { color: var(--primary-blue); }

        /* Card Buku */
        .card-buku {
            background: white; border-radius: 12px; border: 1px solid var(--border-color);
            overflow: hidden; transition: all 0.2s; height: 100%;
        }
        .card-buku:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); transform: translateY(-2px); }
        .card-buku-cover {
            width: 100%; height: 220px; background: linear-gradient(135deg, #1e40af, #3b82f6);
            display: flex; align-items: center; justify-content: center; color: white; position: relative;
        }
        .badge-tersedia { position: absolute; top: 8px; right: 8px; background: #10b981; color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .badge-dipinjam { position: absolute; top: 8px; right: 8px; background: #f59e0b; color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .card-buku-body { padding: 16px; }
        .card-buku-title { font-size: 14px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; line-height: 1.4; }
        .card-buku-author { font-size: 12px; color: var(--text-muted); margin-bottom: 12px; }
        .card-buku-meta { display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: var(--text-muted); margin-bottom: 12px; }
        .btn-detail {
            background: var(--primary-blue); color: white; border: none; border-radius: 8px;
            padding: 8px 16px; font-size: 12px; font-weight: 600; width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-detail:hover { background: var(--primary-light); color: white; }

        /* Filter Bar */
        .filter-bar { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-bottom: 24px; }
        .filter-bar select { border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 13px; background: white; }

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
            .search-box-publik { width: 200px; }
            .nav-menu-publik a { padding: 6px 12px; font-size: 12px; }
        }

        /* ======================================== */
        /* 📱 RESPONSIVE - MOBILE (max-width: 768px) */
        /* ======================================== */
        @media (max-width: 768px) {
            .navbar-publik { padding: 10px 0; }
            .navbar-brand-text h1 { font-size: 14px; }
            .navbar-brand-text small { display: none; }
            .navbar-brand-icon { width: 36px; height: 36px; font-size: 18px; }
            
            /* Hide desktop menu & search */
            .nav-menu-publik, .search-box-publik { display: none; }
            
            /* Show hamburger */
            .hamburger-menu { display: block; }
            
            /* Buttons lebih compact */
            .btn-masuk, .btn-daftar { padding: 6px 12px; font-size: 12px; }
            
            /* Hide avatar di mobile */
            .nav-user-avatar-desktop { display: none !important; }
            
            /* Footer */
            .footer-publik { padding: 30px 0 15px; margin-top: 40px; }
            .footer-publik h6 { font-size: 13px; }
            .footer-publik .col-md-3 { margin-bottom: 24px; }
        }

        /* ======================================== */
        /* 📱 RESPONSIVE - SMALL MOBILE (max-width: 576px) */
        /* ======================================== */
        @media (max-width: 576px) {
            .navbar-brand-text h1 { font-size: 13px; }
            .btn-daftar { display: none; } /* Hide daftar button di HP kecil */
            .btn-masuk { font-size: 11px; padding: 5px 10px; }
            
            /* Card buku lebih kecil */
            .card-buku-cover { height: 180px; }
            .card-buku-title { font-size: 13px; }
        }

        /* ======================================== */
        /* 📱 RESPONSIVE - EXTRA SMALL (max-width: 480px) */
        /* ======================================== */
        @media (max-width: 480px) {
            .btn-masuk { display: none; } /* Hide semua tombol di HP sangat kecil */
            .container { padding: 0 12px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    @php
        $logoSekolah = \App\Models\Setting::get('logo');
    @endphp

    <!-- Navbar Publik -->
    <nav class="navbar-publik">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('publik.beranda') }}" class="navbar-brand-custom">
                    @if($logoSekolah)
                        <div class="navbar-brand-icon" style="background: white; border: 1px solid var(--border-color);">
                            <img src="{{ asset('storage/' . $logoSekolah) }}" alt="Logo Sekolah">
                        </div>
                    @else
                        <div class="navbar-brand-icon"><i class="bi bi-book-half"></i></div>
                    @endif
                    <div class="navbar-brand-text">
                        <h1>Smart Library</h1>
                        <small>SMK Budi Bakti Ciwidey</small>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="nav-menu-publik d-none d-lg-flex">
                    <a href="{{ route('publik.beranda') }}" class="{{ request()->routeIs('publik.beranda') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('publik.katalog') }}" class="{{ request()->routeIs('publik.katalog') ? 'active' : '' }}">Katalog Buku</a>
                    <a href="{{ route('publik.panduan') }}" class="{{ request()->routeIs('publik.panduan') ? 'active' : '' }}">Panduan</a>
                </div>

                <!-- Desktop Search -->
                <div class="search-box-publik d-none d-md-flex">
                    <i class="bi bi-search" style="color: var(--text-muted);"></i>
                    <input type="text" placeholder="Cari judul, ISBN...">
                </div>

                <!-- Desktop Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('login') }}" class="btn-masuk d-none d-sm-inline">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-daftar d-none d-sm-inline">Daftar</a>
                    
                    <!-- User Avatar Desktop -->
                    <div class="nav-user-avatar-desktop" style="width: 36px; height: 36px; background: var(--primary-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                        <i class="bi bi-person"></i>
                    </div>

                    <!-- Hamburger Button -->
                    <button class="hamburger-menu" onclick="toggleMobileMenu()">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <div class="search-mobile">
                <div class="search-box-publik" style="width: 100%;">
                    <i class="bi bi-search" style="color: var(--text-muted);"></i>
                    <input type="text" placeholder="Cari judul buku, ISBN...">
                </div>
            </div>
            <a href="{{ route('publik.beranda') }}" class="{{ request()->routeIs('publik.beranda') ? 'active' : '' }}">
                <i class="bi bi-house me-2"></i> Beranda
            </a>
            <a href="{{ route('publik.katalog') }}" class="{{ request()->routeIs('publik.katalog') ? 'active' : '' }}">
                <i class="bi bi-book me-2"></i> Katalog Buku
            </a>
            <a href="{{ route('publik.panduan') }}" class="{{ request()->routeIs('publik.panduan') ? 'active' : '' }}">
                <i class="bi bi-info-circle me-2"></i> Panduan / Informasi
            </a>
            <hr class="my-2">
            <a href="{{ route('login') }}" style="background: var(--primary-blue); color: white;">
                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="mt-2" style="background: var(--success-green); color: white; text-align: center;">
                <i class="bi bi-person-plus me-2"></i> Daftar Anggota
            </a>
        </div>
    </nav>

    <!-- Content Area -->
    @yield('content')

    <!-- Footer Publik -->
    <footer class="footer-publik">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-3">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        @if($logoSekolah)
                            <div class="navbar-brand-icon" style="width: 32px; height: 32px; font-size: 16px; background: white; border: 1px solid var(--border-color);">
                                <img src="{{ asset('storage/' . $logoSekolah) }}" alt="Logo Sekolah">
                            </div>
                        @else
                            <div class="navbar-brand-icon" style="width: 32px; height: 32px; font-size: 16px;"><i class="bi bi-book-half"></i></div>
                        @endif
                        <strong style="color: var(--primary-blue);">Smart Library</strong>
                    </div>
                    <p class="footer-desc">Pusat sumber belajar digital dan literasi sekolah SMK Budi Bakti Ciwidey. Memberikan akses cepat dan mudah terhadap ribuan koleksi pustaka.</p>
                    <small class="text-muted"><i class="bi bi-patch-check"></i> Akreditasi Perpustakaan Sekolah A</small>
                </div>
                <div class="col-6 col-md-3">
                    <h6>Navigasi Cepat</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('publik.beranda') }}"><i class="bi bi-chevron-right" style="font-size: 10px;"></i> Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('publik.katalog') }}"><i class="bi bi-chevron-right" style="font-size: 10px;"></i> Katalog Buku</a></li>
                        <li class="mb-2"><a href="{{ route('publik.panduan') }}"><i class="bi bi-chevron-right" style="font-size: 10px;"></i> Panduan</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}"><i class="bi bi-chevron-right" style="font-size: 10px;"></i> Registrasi</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6>Jam Operasional</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><span class="d-block">Senin - Kamis</span><strong>07.30 - 15.30</strong></li>
                        <li class="mb-2"><span class="d-block">Jumat</span><strong>07.30 - 11.30</strong></li>
                        <li class="mb-2"><span class="d-block">Sabtu</span><strong>08.00 - 13.00</strong></li>
                        <li><span class="d-block" style="color: #ef4444;">Minggu</span><strong style="color: #ef4444;">Tutup</strong></li>
                    </ul>
                </div>
                <div class="col-12 col-md-3">
                    <h6>Kontak & Lokasi</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2">SMK Budi Bakti Ciwidey<br>Jl. Babakan Tiga No. 82, Ciwidey</li>
                        <li class="mb-2"><i class="bi bi-telephone"></i> (022) 5928-xxx</li>
                        <li><i class="bi bi-envelope"></i> perpus@smkbudibakti.sch.id</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center small text-muted">
                <span>© 2025 Smart Library - SMK Budi Bakti Ciwidey</span>
            </div>
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