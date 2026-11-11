@extends('layouts.petugas')

@section('title', 'Laporan')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Laporan</span>
</div>

<div class="page-header">
    <div class="page-title">
        <h2>Laporan Perpustakaan</h2>
        <p>Cetak dan ekspor berbagai laporan statistik perpustakaan.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-4">
        <div class="panel-card">
            <div class="panel-body text-center" style="padding: 30px;">
                <div style="width: 80px; height: 80px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i class="bi bi-journal-bookmark" style="font-size: 40px; color: var(--primary-blue);"></i>
                </div>
                <h5>Laporan Peminjaman</h5>
                <p class="text-muted small">Laporan seluruh transaksi peminjaman buku per periode.</p>
                <button class="btn-primary-custom btn-sm" onclick="alert('Fitur cetak laporan peminjaman akan segera hadir!')">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="panel-card">
            <div class="panel-body text-center" style="padding: 30px;">
                <div style="width: 80px; height: 80px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i class="bi bi-return-left" style="font-size: 40px; color: #166534;"></i>
                </div>
                <h5>Laporan Pengembalian</h5>
                <p class="text-muted small">Laporan buku yang telah dikembalikan per periode.</p>
                <button class="btn-primary-custom btn-sm" onclick="alert('Fitur cetak laporan pengembalian akan segera hadir!')">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="panel-card">
            <div class="panel-body text-center" style="padding: 30px;">
                <div style="width: 80px; height: 80px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i class="bi bi-alarm" style="font-size: 40px; color: #dc2626;"></i>
                </div>
                <h5>Laporan Keterlambatan</h5>
                <p class="text-muted small">Laporan peminjam yang terlambat mengembalikan buku.</p>
                <button class="btn-primary-custom btn-sm" onclick="alert('Fitur cetak laporan keterlambatan akan segera hadir!')">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="panel-card">
            <div class="panel-body text-center" style="padding: 30px;">
                <div style="width: 80px; height: 80px; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i class="bi bi-people" style="font-size: 40px; color: #d97706;"></i>
                </div>
                <h5>Laporan Anggota</h5>
                <p class="text-muted small">Daftar seluruh anggota perpustakaan aktif.</p>
                <button class="btn-primary-custom btn-sm" onclick="alert('Fitur cetak laporan anggota akan segera hadir!')">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="panel-card">
            <div class="panel-body text-center" style="padding: 30px;">
                <div style="width: 80px; height: 80px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i class="bi bi-book" style="font-size: 40px; color: #4f46e5;"></i>
                </div>
                <h5>Laporan Koleksi Buku</h5>
                <p class="text-muted small">Inventaris dan statistik koleksi buku perpustakaan.</p>
                <button class="btn-primary-custom btn-sm" onclick="alert('Fitur cetak laporan koleksi buku akan segera hadir!')">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="panel-card">
            <div class="panel-body text-center" style="padding: 30px;">
                <div style="width: 80px; height: 80px; background: #f3e8ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i class="bi bi-file-earmark-excel" style="font-size: 40px; color: #7c3aed;"></i>
                </div>
                <h5>Ekspor Excel</h5>
                <p class="text-muted small">Unduh semua data dalam format Excel untuk analisis.</p>
                <button class="btn-primary-custom btn-sm" onclick="alert('Fitur ekspor Excel akan segera hadir!')">
                    <i class="bi bi-download"></i> Unduh Excel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection