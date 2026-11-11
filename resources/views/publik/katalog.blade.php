@extends('layouts.publik')

@section('title', 'Katalog Buku')

@section('content')
<div class="container" style="padding: 24px 0;">
    <!-- Breadcrumb -->
    <div class="breadcrumb-publik mb-3">
        <a href="{{ route('publik.beranda') }}">Beranda</a> / <strong>Katalog</strong>
    </div>

    <!-- Header - RESPONSIVE -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4 gap-3">
        <div>
            <small style="color: var(--primary-blue); font-weight: 600; font-size: 0.85rem;">KOLEKSI PUSTAKA TERBUKA</small>
            <h1 class="fw-bold mb-1" style="font-size: clamp(1.5rem, 4vw, 2rem); line-height: 1.2;">Katalog Koleksi Perpustakaan</h1>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Eksplorasi ribuan judul literatur kurikulum kejuruan, referensi teknis, fiksi, dan sains SMK Budi Bakti</p>
        </div>
        <div class="d-flex gap-3">
            <div class="text-center" style="background: white; padding: 12px 20px; border-radius: 12px; border: 1px solid var(--border-color);">
                <div style="font-size: 20px; font-weight: 800;">{{ $bukus->count() }}+</div>
                <small class="text-muted" style="font-size: 0.75rem;">Ditampilkan</small>
            </div>
        </div>
    </div>

    <!-- Search & Filter - RESPONSIVE -->
    <form method="GET" action="{{ route('publik.katalog') }}" class="card" style="border: none; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 24px;">
        <div class="row g-2 g-md-3">
            <div class="col-12 col-md-6">
                <div class="d-flex align-items-center gap-2" style="background: var(--bg-light); border: 1px solid var(--border-color); border-radius: 8px; padding: 10px 16px;">
                    <i class="bi bi-search" style="color: var(--text-muted);"></i>
                    <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control border-0 bg-transparent" placeholder="Cari judul buku, penulis, atau ISBN..." style="font-size: 14px;">
                </div>
            </div>
            <div class="col-6 col-md-2">
                <select class="form-select" name="kategori" style="font-size: 13px;">
                    <option value="">Semua Kategori</option>
                    <option value="PPLG" {{ request('kategori') == 'PPLG' ? 'selected' : '' }}>PPLG / RPL</option>
                    <option value="Fiksi" {{ request('kategori') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                    <option value="Non-Fiksi" {{ request('kategori') == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select class="form-select" name="status" style="font-size: 13px;">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100" style="background: var(--primary-blue); border: none; padding: 10px; font-size: 14px;">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </div>
    </form>

    <!-- Filter Aktif -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
        <small class="text-muted" style="font-size: 0.85rem;"><i class="bi bi-funnel"></i> Menampilkan {{ $bukus->count() }} judul buku</small>
        @if(!empty($search))
            <small class="text-muted" style="font-size: 0.85rem;">Hasil pencarian untuk: <strong style="color: var(--primary-blue);">"{{ $search }}"</strong></small>
        @endif
    </div>

    <!-- Grid Buku - RESPONSIVE: 2 di HP, 3 di tablet, 4 di desktop -->
    <div class="row g-3 g-md-4">
        @forelse($bukus as $buku)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card-buku">
                <!-- COVER BUKU -->
                <div class="card-buku-cover" style="height: 180px; position: relative;">
                    @if(!empty($buku->cover))
                        <img src="{{ asset('storage/' . $buku->cover) }}" 
                             alt="{{ $buku->judul }}" 
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="display: none; width: 100%; height: 100%; background: linear-gradient(135deg, #1e40af, #3b82f6); align-items: center; justify-content: center; color: white;">
                            <i class="bi bi-book" style="font-size: 48px;"></i>
                        </div>
                    @else
                        <i class="bi bi-book" style="font-size: 48px;"></i>
                    @endif
                    
                    @if(($buku->stok ?? 0) > 0)
                        <span class="badge-tersedia" style="font-size: 9px; padding: 3px 6px;"><i class="bi bi-check-circle"></i> Tersedia</span>
                    @else
                        <span class="badge-dipinjam" style="font-size: 9px; padding: 3px 6px;"><i class="bi bi-clock"></i> Dipinjam</span>
                    @endif
                </div>
                
                <div class="card-buku-body">
                    <div style="font-size: 9px; font-weight: 700; color: var(--primary-blue); letter-spacing: 0.5px;">
                        {{ strtoupper($buku->kategori ?? 'UMUM') }} • {{ $buku->tahun_penerbit ?? $buku->tahun_terbit ?? '2024' }}
                    </div>
                    <div class="card-buku-title mt-1" style="font-size: 12px; line-height: 1.3;">
                        {{ Str::limit($buku->judul ?? 'Judul Buku', 35) }}
                    </div>
                    <div class="card-buku-author" style="font-size: 10px;">
                        Oleh: {{ Str::limit($buku->penulis ?? $buku->pengarang ?? 'Penulis', 25) }}
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 10px;">
                        <span style="color: {{ ($buku->stok ?? 0) > 0 ? '#10b981' : '#f59e0b' }};">
                            <i class="bi bi-{{ ($buku->stok ?? 0) > 0 ? 'check-circle' : 'exclamation-triangle' }}"></i>
                            {{ ($buku->stok ?? 0) > 0 ? 'Stok Ada' : 'Habis' }}
                        </span>
                        <span class="text-muted">{{ $buku->stok ?? 0 }} Eks</span>
                    </div>
                    <a href="{{ route('publik.detail', $buku->id_buku) }}" class="btn-detail" style="font-size: 10px; padding: 6px 10px;">
                        Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-inbox" style="font-size: 48px; color: var(--text-muted);"></i>
            <p class="text-muted mt-2">Tidak ada buku yang ditemukan.</p>
            <a href="{{ route('publik.katalog') }}" class="btn btn-sm btn-outline-primary mt-2">Reset Pencarian</a>
        </div>
        @endforelse
    </div>

    <!-- Pagination - RESPONSIVE -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 gap-2">
        <small class="text-muted" style="font-size: 0.85rem;">Halaman 1</small>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#" style="background: var(--primary-blue); border-color: var(--primary-blue);">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Responsive adjustments for katalog */
@media (max-width: 768px) {
    .card-buku-cover {
        height: 160px !important;
    }
    
    .card-buku-title {
        font-size: 11px !important;
    }
    
    .card-buku-author {
        font-size: 9px !important;
    }
    
    .btn-detail {
        font-size: 9px !important;
        padding: 5px 8px !important;
    }
    
    .badge-tersedia, .badge-dipinjam {
        font-size: 8px !important;
        padding: 2px 5px !important;
    }
}

@media (max-width: 576px) {
    .card-buku-cover {
        height: 140px !important;
    }
    
    .col-6 {
        padding: 0 6px;
    }
    
    .card-buku-body {
        padding: 10px !important;
    }
}
</style>
@endpush