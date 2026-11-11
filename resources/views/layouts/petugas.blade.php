<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SmartLib Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;
            --accent-orange: #f59e0b;
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
        .brand-text small { font-size: 11px; color: var(--text-secondary); display: block; }

        .sidebar-menu { flex: 1; overflow-y: auto; padding: 16px 0; }
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

        .sidebar-footer {
            padding: 16px 20px; border-top: 1px solid var(--border-color);
            display: flex; justify-content: space-between; align-items: center;
            font-size: 12px; color: var(--text-secondary);
        }
        .sidebar-footer .version {
            background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-size: 11px;
        }

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
        .btn-transaksi {
            background: var(--primary-blue); color: white; border: none;
            padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 6px; text-decoration: none;
        }
        .btn-transaksi:hover { background: var(--primary-dark); color: white; }
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

        /* Page Header */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
        .page-title h2 { font-size: 24px; font-weight: 800; color: var(--text-primary); margin: 0 0 6px 0; }
        .page-title p { font-size: 13px; color: var(--text-secondary); margin: 0; }

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
        .btn-warning-custom {
            background: var(--accent-orange); color: white; border: none; border-radius: 8px;
            padding: 10px 20px; font-size: 13px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 8px; cursor: pointer; text-decoration: none;
        }
        .btn-warning-custom:hover { background: #d97706; color: white; }

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

        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
        .status-active { background: #dcfce7; color: #16a34a; }
        .status-active::before { content: ''; width: 6px; height: 6px; background: #16a34a; border-radius: 50%; }
        .status-warning { background: #fef3c7; color: #d97706; }
        .status-danger { background: #fee2e2; color: #dc2626; }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white; border-radius: 12px; padding: 24px;
            margin-bottom: 24px; position: relative; overflow: hidden;
        }
        .hero-banner::before {
            content: ''; position: absolute; top: -50%; right: -10%;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.05); border-radius: 50%;
        }
        .hero-banner .hero-title { font-size: 24px; font-weight: 800; margin-bottom: 8px; }
        .hero-banner .hero-subtitle { font-size: 13px; opacity: 0.9; margin-bottom: 16px; }
        .hero-banner .hero-meta { font-size: 11px; opacity: 0.8; margin-bottom: 16px; }
        .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }

        /* Reminder Card */
        .reminder-card {
            background: white; border-radius: 12px; border: 1px solid var(--border-color);
            padding: 16px; margin-bottom: 12px; border-left: 4px solid #ef4444;
        }
        .reminder-card .reminder-name { font-size: 13px; font-weight: 700; color: var(--text-primary); }
        .reminder-card .reminder-info { font-size: 11px; color: var(--text-secondary); margin-top: 4px; }
        .reminder-card .reminder-denda { font-size: 12px; font-weight: 700; color: #ef4444; }
        .btn-wa {
            background: #10b981; color: white; border: none; border-radius: 6px;
            padding: 6px 12px; font-size: 11px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .btn-wa:hover { background: #059669; color: white; }

        /* Agenda */
        .agenda-item {
            background: #f8fafc; border-radius: 10px; padding: 14px;
            margin-bottom: 10px; display: flex; gap: 12px; align-items: flex-start;
        }
        .agenda-icon {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .agenda-content .agenda-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .agenda-content .agenda-desc { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }

        /* Book Card */
        .book-card {
            background: white; border-radius: 10px; border: 1px solid var(--border-color);
            padding: 14px; text-align: center;
        }
        .book-cover {
            width: 100%; height: 140px; background: #f1f5f9;
            border-radius: 8px; margin-bottom: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-secondary); font-size: 11px;
        }
        .book-title { font-size: 12px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .book-author { font-size: 11px; color: var(--text-secondary); margin-bottom: 8px; }
        .book-stat { font-size: 11px; color: var(--text-secondary); }

        /* Scanner Box */
        .scanner-box {
            background: #f8fafc; border: 2px dashed var(--border-color);
            border-radius: 10px; padding: 20px; text-align: center;
        }
        .scanner-box input {
            border: 1px solid var(--border-color); border-radius: 8px;
            padding: 10px 14px; width: 100%; font-size: 13px; margin-bottom: 10px;
        }

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
                <small>SMK Budi Bakti</small>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section-title">Sirkulasi & Operasional</div>
            
            <a href="{{ route('dashboard.petugas') }}" class="{{ request()->routeIs('dashboard.petugas') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i><span>Data Buku</span>
            </a>
            <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <i class="bi bi-folder"></i><span>Master Kategori</span>
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
            <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.keterlambatan') ? 'active' : '' }}">
                <i class="bi bi-clock"></i><span>Keterlambatan</span>
            </a>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i><span>Laporan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <span><i class="bi bi-gear"></i> SMK BB Ciwidey</span>
            <span class="version">v2.4</span>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="search-box">
                <i class="bi bi-search" style="color: var(--text-secondary);"></i>
                <input type="text" placeholder="Cari judul buku, ISBN, atau NIS siswa...">
            </div>
            <div class="nav-right">
                <a href="{{ route('peminjaman.create') }}" class="btn-transaksi">
                    <i class="bi bi-plus-circle"></i> Transaksi Baru
                </a>
                <button class="nav-btn">
                    <i class="bi bi-bell"></i>
                    <span class="badge-notif"></span>
                </button>
                
                <!-- PROFILE & LOGOUT SECTION -->
                <div class="user-profile">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->nama ?? 'P', 0, 1)) }}</div>
                    <div class="user-info d-none d-md-block">
                        <div class="user-name">{{ Auth::user()->nama ?? 'Petugas' }}</div>
                        <div class="user-role">Petugas Perpustakaan</div>
                    </div>
                    
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