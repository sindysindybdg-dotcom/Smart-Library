@extends('layouts.siswa')

@section('title', 'Katalog Buku')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="{{ route('siswa.dashboard') }}">Beranda</a> / 
    <strong>Katalog Buku</strong>
</div>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="font-size: 1.5rem;">Katalog Koleksi Buku</h2>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">Jelajahi koleksi perpustakaan SMK Budi Bakti Ciwidey</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <select class="form-select" style="width: 160px; font-size: 13px;" onchange="filterKategori(this.value)">
            <option value="">Semua Kategori</option>
            @foreach($kategoris ?? [] as $kategori)
                <option value="{{ $kategori->id_kategori ?? $kategori->id }}" 
                        {{ request('kategori') == ($kategori->id_kategori ?? $kategori->id) ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori ?? $kategori->nama }}
                </option>
            @endforeach
        </select>
        
        <select class="form-select" style="width: 160px; font-size: 13px;" onchange="sortBuku(this.value)">
            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
            <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
            <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Judul A-Z</option>
        </select>
    </div>
</div>

<!-- Search Box -->
<div class="card-custom mb-4">
    <form method="GET" action="{{ route('siswa.dashboard') }}">
        <div class="row g-2">
            <div class="col-12 col-md-8">
                <div class="nav-search" style="width: 100%;">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari judul buku, penulis, ISBN..." style="font-size: 14px;">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <button type="submit" class="btn btn-primary-custom w-100" style="font-size: 13px;">
                    <i class="bi bi-search"></i> Cari Buku
                </button>
            </div>
        </div>
    </form>
    @if(!empty($search))
        <div class="mt-2">
            <small class="text-muted">Hasil pencarian untuk: <strong>"{{ $search }}"</strong> ({{ $bukus->total() }} buku)</small>
        </div>
    @endif
</div>

<!-- Buku Grid - RESPONSIVE -->
<div class="row g-3">
    @forelse($bukus as $buku)
    @php
        $bukuId = $buku->id_buku ?? $buku->id ?? null;
        $detailUrl = $bukuId ? route('publik.detail', $bukuId) : '#';
        $hasDetail = $bukuId !== null;
    @endphp
    
    <!-- Responsive Grid: 2 cols mobile, 3 cols tablet, 4 cols desktop -->
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card-custom h-100" style="padding: 12px; display: flex; flex-direction: column;">
            
            <!-- Cover Buku -->
            @if($hasDetail)
                <a href="{{ $detailUrl }}" class="text-decoration-none">
            @else
                <div>
            @endif
                <div style="width: 100%; height: 160px; border-radius: 8px; margin-bottom: 10px; overflow: hidden; position: relative; background: #f1f5f9;">
                    @if(!empty($buku->cover))
                        <img src="{{ asset('storage/' . $buku->cover) }}" 
                             alt="{{ $buku->judul }}" 
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="display: none; width: 100%; height: 100%; background: linear-gradient(135deg, #1e40af, #3b82f6); align-items: center; justify-content: center; color: white;">
                            <i class="bi bi-book" style="font-size: 40px;"></i>
                        </div>
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e40af, #3b82f6); display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="bi bi-book" style="font-size: 40px;"></i>
                        </div>
                    @endif
                    
                    @if(($buku->stok ?? 0) > 0)
                        <span style="position: absolute; top: 6px; right: 6px; background: #10b981; color: white; padding: 3px 6px; border-radius: 4px; font-size: 9px; font-weight: 600;">✓ Tersedia</span>
                    @else
                        <span style="position: absolute; top: 6px; right: 6px; background: #ef4444; color: white; padding: 3px 6px; border-radius: 4px; font-size: 9px; font-weight: 600;">Habis</span>
                    @endif
                </div>
            @if($hasDetail)
                </a>
            @else
                </div>
            @endif
            
            <!-- Info Buku -->
            <div class="flex-grow-1">
                <small class="text-muted d-block mb-1" style="font-size: 10px;">
                    {{ strtoupper($buku->kategori->nama_kategori ?? $buku->kategori->nama ?? 'UMUM') }}
                    @if(!empty($buku->tahun_terbit)) • {{ $buku->tahun_terbit }} @endif
                </small>
                
                <h6 class="fw-bold mb-1" style="font-size: 13px; line-height: 1.3; margin-bottom: 4px;">
                    {{ Str::limit($buku->judul, 40) }}
                </h6>
                <small class="text-muted d-block mb-2" style="font-size: 11px;">
                    {{ Str::limit($buku->penulis ?? $buku->pengarang ?? 'Penulis Tidak Diketahui', 25) }}
                </small>
            </div>
            
            <!-- Stok & Tombol -->
            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="{{ ($buku->stok ?? 0) > 0 ? 'text-success' : 'text-danger' }} fw-semibold" style="font-size: 11px;">
                        <i class="bi bi-{{ ($buku->stok ?? 0) > 0 ? 'check-circle' : 'x-circle' }}"></i> 
                        {{ $buku->stok ?? 0 }} Eks
                    </small>
                </div>
                
                @if($hasDetail)
                    <a href="{{ $detailUrl }}" class="btn btn-primary btn-sm w-100" style="font-size: 11px; padding: 6px;">
                        Detail →
                    </a>
                @else
                    <button class="btn btn-secondary btn-sm w-100" disabled style="font-size: 10px; padding: 5px;">
                        Detail
                    </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="bi bi-inbox" style="font-size: 48px; color: #94a3b8;"></i>
        <p class="text-muted mt-2">Tidak ada buku ditemukan.</p>
        @if(!empty($search))
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-sm btn-outline-primary mt-2">Reset Pencarian</a>
        @endif
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($bukus->hasPages())
<div class="d-flex justify-content-center mt-5">
    {{ $bukus->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
function filterKategori(kategoriId) {
    const url = new URL(window.location.href);
    if (kategoriId) {
        url.searchParams.set('kategori', kategoriId);
    } else {
        url.searchParams.delete('kategori');
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function sortBuku(sortType) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sortType);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endpush

@push('styles')
<style>
/* Responsive adjustments for catalog */
@media (max-width: 768px) {
    .breadcrumb-custom {
        font-size: 12px;
    }
    
    h2.fw-bold {
        font-size: 1.25rem !important;
    }
    
    .form-select {
        width: 100% !important;
        margin-bottom: 8px;
        font-size: 13px;
    }
    
    .card-custom {
        padding: 12px !important;
    }
}

@media (max-width: 576px) {
    .col-6 {
        padding: 0 6px;
    }
    
    .card-custom {
        padding: 8px !important;
    }
    
    .btn-primary {
        font-size: 10px !important;
        padding: 5px !important;
    }
}
</style>
@endpush