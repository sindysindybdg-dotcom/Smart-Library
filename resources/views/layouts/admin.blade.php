<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SmartLib</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-dark: #1e40af;
            --bg-color: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --sidebar-width: 260px;
        }
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--bg-color); color: var(--text-primary); overflow-x: hidden; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width); height: 100vh;
            background: white; border-right: 1px solid var(--border-color);
            position: fixed; top: 0; left: 0; z-index: 1000;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 16px 20px; border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; gap: 12px;
        }
        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px; overflow: hidden;
        }
        .brand-icon img { width: 100%; height: 100%; object-fit: contain; }
        .brand-text h1 { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0; }
        .brand-text small { font-size: 11px; color: var(--text-secondary); display: block; line-height: 1.3; }

        .sidebar-menu { flex: 1; overflow-y: auto; padding: 16px 0; }
        .menu-section { margin-bottom: 20px; }
        .menu-section-title {
            font-size: 10px; font-weight: 700; color: var(--text-secondary);
            text-transform: uppercase; letter-spacing: 1px;
            padding: 0 20px; margin-bottom: 8px;
        }
        .sidebar-menu a {
            display: flex; align-items: center; padding: 9px 20px;
            color: #475569; text-decoration: none; font-size: 13px; font-weight: 500;
            transition: all 0.2s; gap: 12px; margin: 2px 10px; border-radius: 8px;
        }
        .sidebar-menu a:hover { background: #f1f5f9; color: var(--text-primary); }
        .sidebar-menu a.active { background: var(--primary-blue); color: white; }
        .sidebar-menu a i { font-size: 16px; width: 20px; }
        .badge-root {
            background: #fee2e2; color: #dc2626; font-size: 9px;
            padding: 2px 6px; border-radius: 4px; font-weight: 700; margin-left: auto;
        }
        .sidebar-footer {
            padding: 16px 20px; border-top: 1px solid var(--border-color);
            font-size: 12px; color: var(--text-secondary);
        }
        .sidebar-footer .status { display: flex; align-items: center; gap: 6px; }
        .status-dot { width: 8px; height: 8px; background: #10b981; border-radius: 50%; }

        /* Main Wrapper */
        .main-wrapper { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }

        /* Top Navigation */
        .top-nav {
            background: white; border-bottom: 1px solid var(--border-color);
            padding: 12px 24px; display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 100;
        }
        .search-box {
            background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px;
            padding: 8px 16px; display: flex; align-items: center; gap: 8px; width: 380px;
        }
        .search-box input { border: none; background: transparent; outline: none; font-size: 13px; width: 100%; }
        .nav-right { display: flex; align-items: center; gap: 16px; }
        .mode-badge {
            background: #eff6ff; color: var(--primary-blue); padding: 6px 12px;
            border-radius: 20px; font-size: 12px; font-weight: 600;
            display: flex; align-items: center; gap: 6px;
        }
        .nav-btn {
            background: none; border: none; font-size: 20px; color: var(--text-secondary);
            cursor: pointer; position: relative; padding: 8px; border-radius: 8px;
        }
        .nav-btn:hover { background: #f1f5f9; }
        .badge-notif {
            position: absolute; top: 4px; right: 4px;
            width: 8px; height: 8px; background: #ef4444; border-radius: 50%;
        }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-avatar {
            width: 36px; height: 36px; background: var(--primary-blue);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 14px;
        }
        .user-info .user-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .user-info .user-role { font-size: 11px; color: var(--text-secondary); }

        /* Content Area */
        .content-area { padding: 28px 32px; flex: 1; }

        /* Breadcrumb */
        .breadcrumb-custom { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-secondary); margin-bottom: 12px; }
        .breadcrumb-custom a { color: var(--text-secondary); text-decoration: none; }
        .breadcrumb-custom a:hover { color: var(--primary-blue); }
        .breadcrumb-custom .separator { font-size: 10px; }

        /* Page Header */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
        .page-title h2 { font-size: 24px; font-weight: 800; color: var(--text-primary); margin: 0 0 6px 0; }
        .page-title p { font-size: 13px; color: var(--text-secondary); margin: 0; max-width: 600px; line-height: 1.5; }

        /* Buttons */
        .btn-primary-custom {
            background: var(--primary-blue); color: white; border: none; border-radius: 8px;
            padding: 10px 20px; font-size: 13px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 8px; cursor: pointer; text-decoration: none;
        }
        .btn-primary-custom:hover { background: var(--primary-dark); color: white; }
        .btn-outline-custom {
            background: white; color: var(--text-primary); border: 1px solid var(--border-color);
            border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 500;
            display: inline-flex; align-items: center; gap: 8px; cursor: pointer; text-decoration: none;
        }
        .btn-outline-custom:hover { background: #f8fafc; }

        /* Info Card */
        .info-card {
            background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px;
            padding: 20px; display: flex; gap: 16px; align-items: flex-start; margin-bottom: 24px;
        }
        .info-icon {
            width: 44px; height: 44px; background: var(--primary-blue);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px; flex-shrink: 0;
        }
        .info-content { flex: 1; }
        .info-content h5 { font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0 0 6px 0; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .info-content p { font-size: 12px; color: var(--text-secondary); margin: 0; line-height: 1.6; }
        .info-right { text-align: right; font-size: 11px; color: var(--text-secondary); flex-shrink: 0; }
        .info-right .status-ok { color: #10b981; font-weight: 600; }

        /* Stat Cards */
        .stat-card {
            background: white; border-radius: 12px; padding: 20px;
            border: 1px solid var(--border-color);
        }
        .stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        .stat-label { font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .stat-value { font-size: 28px; font-weight: 800; color: var(--text-primary); margin-bottom: 4px; }
        .stat-value small { font-size: 14px; font-weight: 500; color: var(--text-secondary); }
        .stat-sub { font-size: 12px; color: var(--text-secondary); margin-bottom: 12px; }
        .stat-footer { display: flex; justify-content: space-between; align-items: center; font-size: 12px; }

        /* Badges */
        .badge-custom { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; display: inline-block; }
        .badge-success { background: #dcfce7; color: #16a34a; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-danger { background: #fee2e2; color: #dc2626; }
        .badge-info { background: #dbeafe; color: #2563eb; }
        .badge-purple { background: #e0e7ff; color: #4f46e5; }
        .badge-gray { background: #f1f5f9; color: #64748b; }

        /* Panel Card */
        .panel-card { background: white; border-radius: 12px; border: 1px solid var(--border-color); margin-bottom: 24px; }
        .panel-header { padding: 20px 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .panel-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0; }
        .panel-body { padding: 24px; }

        /* Table */
        .table-modern { width: 100%; font-size: 13px; }
        .table-modern thead th {
            background: #f8fafc; padding: 12px 16px; font-size: 10px; font-weight: 700;
            color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px;
            border: none; text-align: left; white-space: nowrap;
        }
        .table-modern tbody td { padding: 14px 16px; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
        .table-modern tbody tr:hover { background: #f8fafc; }

        .user-cell { display: flex; align-items: center; gap: 12px; }
        .user-avatar-small {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 12px; color: white; flex-shrink: 0;
        }
        .user-details strong { display: block; font-size: 13px; font-weight: 600; margin-bottom: 2px; }
        .user-details small { font-size: 11px; color: var(--text-secondary); }

        .role-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .role-admin { background: #dbeafe; color: #2563eb; }
        .role-petugas { background: #e0e7ff; color: #4f46e5; }
        .role-anggota { background: #f1f5f9; color: #64748b; }

        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
        .status-active { background: #dcfce7; color: #16a34a; }
        .status-active::before { content: ''; width: 6px; height: 6px; background: #16a34a; border-radius: 50%; }
        .status-inactive { background: #fee2e2; color: #dc2626; }
        .status-inactive::before { content: ''; width: 6px; height: 6px; background: #dc2626; border-radius: 50%; }

        /* Filter Bar */
        .filter-bar { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-bottom: 20px; }
        .filter-bar .search-box { width: 280px; }
        .filter-bar select { border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 13px; background: white; }

        /* Pagination */
        .pagination-custom { display: flex; align-items: center; gap: 4px; }
        .pagination-custom button {
            padding: 6px 12px; border: 1px solid var(--border-color); background: white;
            border-radius: 6px; font-size: 13px; cursor: pointer;
        }
        .pagination-custom button.active { background: var(--primary-blue); color: white; border-color: var(--primary-blue); }

        /* Role Cards */
        .role-card { background: white; border-radius: 12px; border: 1px solid var(--border-color); padding: 24px; height: 100%; }
        .role-card h5 { font-size: 15px; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .role-card p { font-size: 12px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 16px; }
        .role-card .role-footer { font-size: 12px; color: var(--text-secondary); display: flex; justify-content: space-between; align-items: center; }

        /* Tabs */
        .tabs-custom { display: flex; gap: 4px; border-bottom: 1px solid var(--border-color); margin-bottom: 24px; }
        .tab-btn {
            padding: 10px 16px; border: none; background: none; font-size: 13px;
            font-weight: 500; color: var(--text-secondary); cursor: pointer;
            border-bottom: 2px solid transparent; display: flex; align-items: center; gap: 6px;
        }
        .tab-btn.active { color: var(--primary-blue); border-bottom-color: var(--primary-blue); font-weight: 600; }

        /* Setting Cards */
        .setting-card { background: #f8fafc; border-radius: 10px; padding: 16px; margin-bottom: 12px; }
        .setting-card label { font-size: 12px; font-weight: 600; color: var(--text-primary); display: block; margin-bottom: 4px; }
        .setting-card .key-info { font-size: 10px; color: var(--text-secondary); margin-bottom: 10px; }
        .setting-card .desc { font-size: 11px; color: var(--text-secondary); margin-top: 8px; line-height: 1.5; }

        /* Toggle */
        .toggle-row {
            display: flex; justify-content: space-between; align-items: flex-start;
            padding: 16px; background: #f8fafc; border-radius: 10px; margin-bottom: 12px;
        }
        .toggle-row .toggle-info { flex: 1; }
        .toggle-row .toggle-title { font-size: 13px; font-weight: 600; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
        .toggle-row .toggle-desc { font-size: 11px; color: var(--text-secondary); line-height: 1.5; }
        .form-switch .form-check-input { width: 44px; height: 24px; }

        /* Server Card */
        .server-card {
            background: linear-gradient(135deg, #1e40af, #2563eb); color: white;
            border-radius: 12px; padding: 20px;
        }
        .server-card .server-title { font-size: 10px; opacity: 0.8; letter-spacing: 1px; margin-bottom: 4px; }
        .server-card .server-name { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .server-card .server-spec { font-size: 11px; opacity: 0.9; margin-bottom: 16px; }

        @media (max-width: 992px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .sidebar.active { margin-left: 0; }
            .main-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        @php
            // Ambil logo dari database secara otomatis
            $logoSekolah = \App\Models\Setting::get('logo');
        @endphp
        
        <div class="sidebar-brand">
            @if($logoSekolah)
                <div class="brand-icon" style="background: white; border: 1px solid var(--border-color); padding: 4px;">
                    <img src="{{ asset('storage/' . $logoSekolah) }}" alt="Logo Sekolah">
                </div>
            @else
                <div class="brand-icon"><i class="bi bi-book-half"></i></div>
            @endif
            <div class="brand-text">
                <h1>SmartLib</h1>
                <small>SMK Budi Bakti Ciwidey - Administrasi</small>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Sirkulasi & Operasional</div>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
                    <i class="bi bi-book"></i><span>Data Buku</span>
                </a>
                <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="bi bi-folder"></i><span>Master Data</span>
                </a>
                <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i><span>Data Anggota</span>
                </a>
                <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i><span>Peminjaman</span>
                </a>
                <a href="{{ route('pengembalian.index') }}" class="{{ request()->routeIs('pengembalian.*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-return-left"></i><span>Pengembalian</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i><span>Laporan</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Administrator Khusus <span class="badge-root">ROOT</span></div>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i><span>Kelola Pengguna</span>
                </a>
                <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i><span>Pengaturan Sistem</span>
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="status">
                <span class="status-dot"></span>
                <span>Hak Akses Superadmin Aktif • Versi Sistem 4.1.8</span>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="search-box">
                <i class="bi bi-search" style="color: var(--text-secondary);"></i>
                <input type="text" placeholder="Cari data sistem, user, atau pengaturan...">
            </div>
            <div class="nav-right">
                <div class="mode-badge">
                    <i class="bi bi-shield-check"></i> Mode Administrator
                </div>
                <button class="nav-btn">
                    <i class="bi bi-bell"></i>
                    <span class="badge-notif"></span>
                </button>
                
                <!-- PROFILE & LOGOUT SECTION -->
                <div class="user-profile">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->nama ?? 'A', 0, 1)) }}</div>
                    <div class="user-info d-none d-md-block">
                        <div class="user-name">{{ Auth::user()->nama ?? 'Admin' }}</div>
                        <div class="user-role">Admin Sistem • Superadmin</div>
                    </div>
                    <!-- TOMBOL LOGOUT AMAN -->
                    <form action="{{ route('logout') }}" method="POST" style="margin-left: 12px;">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm" title="Logout" style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; padding: 0;">
                            <i class="bi bi-box-arrow-right" style="font-size: 14px; color: var(--text-secondary);"></i>
                        </button>
                    </form>
                </div>
                <!-- END PROFILE & LOGOUT SECTION -->
                
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>