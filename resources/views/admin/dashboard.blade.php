@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="#">Admin Perpustakaan</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span>Dashboard</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h2>Dashboard Overview</h2>
        <p>Ringkasan operasional dan statistik perpustakaan</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-outline-custom">
            <i class="bi bi-download"></i> Ekspor Laporan
        </button>
        <button class="btn-primary-custom">
            <i class="bi bi-plus-circle"></i> Transaksi Baru
        </button>
    </div>
</div>

<!-- Info Card -->
<div class="info-card">
    <div class="info-icon">
        <i class="bi bi-shield-check"></i>
    </div>
    <div class="info-content">
        <h5>Sistem Beroperasi Normal</h5>
        <p>Semua layanan perpustakaan digital berjalan dengan baik. Terakhir sinkronisasi: Hari ini, 08:30 WIB</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Anggota</div>
                    <div class="stat-value">{{ number_format($totalAnggota, 0, ',', '.') }}</div>
                    <div class="stat-sub">Aktif semester ini</div>
                </div>
                <div class="stat-icon" style="background: #dbeafe; color: #2563eb;">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="stat-footer">
                <span style="color: #10b981; font-weight: 600;"><i class="bi bi-arrow-up"></i> 12.5%</span>
                <span class="text-muted">dari tahun lalu</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Koleksi Buku</div>
                    <div class="stat-value">{{ number_format($totalBuku, 0, ',', '.') }}</div>
                    <div class="stat-sub">Judul terkatalog</div>
                </div>
                <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                    <i class="bi bi-book"></i>
                </div>
            </div>
            <div class="stat-footer">
                <span style="color: #10b981; font-weight: 600;"><i class="bi bi-arrow-up"></i> 8.2%</span>
                <span class="text-muted">bulan ini</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Peminjaman Aktif</div>
                    <div class="stat-value">{{ number_format($peminjamanAktif, 0, ',', '.') }}</div>
                    <div class="stat-sub">Sedang dipinjam</div>
                </div>
                <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
            </div>
            <div class="stat-footer">
                <span style="color: #10b981; font-weight: 600;"><i class="bi bi-arrow-up"></i> 5.3%</span>
                <span class="text-muted">minggu ini</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Pengembalian Hari Ini</div>
                    <div class="stat-value">24</div>
                    <div class="stat-sub">Buku dikembalikan</div>
                </div>
                <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
            <div class="stat-footer">
                <span class="badge-custom badge-success">98.1% Tepat Waktu</span>
            </div>
        </div>
    </div>
</div>
@endsection