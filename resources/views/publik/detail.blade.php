@extends('layouts.publik')

@section('title', $buku->judul ?? 'Detail Buku')

@section('content')
<div class="container" style="padding: 24px 0;">
    <!-- Breadcrumb -->
    <div class="breadcrumb-publik mb-2">
        <a href="{{ route('publik.katalog') }}"><i class="bi bi-arrow-left"></i> Kembali ke Katalog</a>
    </div>
    <div class="text-end mb-3">
        <small class="text-muted" style="font-size: 0.8rem;">
            Koleksi Perpustakaan / <span style="color: var(--primary-blue);">{{ $buku->kategori ?? 'Umum' }}</span>
        </small>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Cover & Info Fisik -->
        <div class="col-12 col-lg-4">
            <!-- Cover Buku -->
            <div class="card" style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <div style="background: linear-gradient(135deg, #1e40af, #3b82f6); min-height: 320px; display: flex; justify-content: center; align-items: center;">
                    @if(!empty($buku->cover))
                        <img src="{{ asset('storage/' . $buku->cover) }}"
                             alt="Sampul {{ $buku->judul }}"
                             style="display: block; width: 100%; height: auto; max-height: 420px; object-fit: contain;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="display: none; min-height: 320px; width: 100%; background: linear-gradient(135deg, #1e40af, #3b82f6); flex-direction: column; justify-content: center; align-items: center; padding: 24px; color: white;">
                            <i class="bi bi-book" style="font-size: 64px;"></i>
                            <span class="mt-2">Cover belum tersedia</span>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 24px; color: white;">
                            <i class="bi bi-book" style="font-size: clamp(60px, 15vw, 96px);"></i>
                            <span style="font-size: 0.85rem; opacity: 0.9;">Cover belum tersedia</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Ketersediaan -->
            <div class="card mt-3" style="border: 1px solid {{ ($buku->stok ?? 0) > 0 ? '#10b981' : '#f59e0b' }}; border-radius: 12px; padding: 16px; background: {{ ($buku->stok ?? 0) > 0 ? '#dcfce7' : '#fef3c7' }};">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-{{ ($buku->stok ?? 0) > 0 ? 'check-circle' : 'clock' }}" style="color: {{ ($buku->stok ?? 0) > 0 ? '#10b981' : '#f59e0b' }}; font-size: 20px;"></i>
                        <strong style="color: {{ ($buku->stok ?? 0) > 0 ? '#10b981' : '#f59e0b' }}; font-size: 0.9rem;">
                            {{ ($buku->stok ?? 0) > 0 ? 'Tersedia untuk Dipinjam' : 'Sedang Dipinjam' }}
                        </strong>
                    </div>
                    <span class="badge" style="background: {{ ($buku->stok ?? 0) > 0 ? '#10b981' : '#f59e0b' }}; color: white; font-size: 0.8rem;">{{ $buku->stok ?? 0 }} Eksemplar</span>
                </div>
            </div>

            <!-- Penempatan Fisik -->
            <div class="card mt-3" style="border: none; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;"><i class="bi bi-geo-alt"></i> PENEMPATAN FISIK</h6>
                    <i class="bi bi-info-circle" style="color: var(--primary-blue);"></i>
                </div>
                <div style="background: var(--bg-light); padding: 12px; border-radius: 8px; margin-bottom: 12px;">
                    <i class="bi bi-bookmark" style="color: var(--primary-blue);"></i>
                    <strong style="font-size: 0.9rem;">{{ $buku->lokasi_rak ? 'Rak '.$buku->lokasi_rak : 'Lokasi rak belum diatur' }}</strong>
                </div>
                @if($buku->lokasi_rak)
                    <small class="text-muted" style="font-size: 0.8rem;">Silakan konfirmasi lokasi buku kepada petugas perpustakaan.</small>
                @else
                    <small class="text-muted" style="font-size: 0.8rem;">Silakan tanyakan lokasi buku kepada petugas perpustakaan.</small>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Detail Buku -->
        <div class="col-12 col-lg-8">
            <!-- Tags -->
            <div class="d-flex gap-2 mb-3 flex-wrap">
                <span class="badge" style="background: var(--accent-blue); color: var(--primary-blue); padding: 6px 12px; font-size: 0.8rem;">{{ $buku->kategori ?? 'Umum' }}</span>
            </div>

            <!-- Judul -->
            <h1 class="fw-bold mb-2 text-break" style="font-size: clamp(1.25rem, 4vw, 2rem); line-height: 1.3;">{{ $buku->judul ?? 'Judul Buku' }}</h1>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Ditulis oleh <strong class="text-break">{{ $buku->penulis ?? $buku->pengarang ?? 'Penulis' }}</strong> • 
                Kategori <span style="color: var(--primary-blue);">{{ $buku->kategori ?? 'Umum' }}</span> • 
                Tahun Terbit {{ $buku->tahun_penerbit ?? $buku->tahun_terbit ?? '-' }}
            </p>

            <!-- Info Grid - RESPONSIVE: 2 kolom di HP, 4 di desktop -->
            <div class="row g-3 my-4" style="background: var(--bg-light); padding: 20px; border-radius: 12px;">
                <div class="col-6 col-md-3">
                    <small class="text-muted" style="font-size: 0.75rem;">ISBN</small>
                    <div class="fw-bold text-break" style="font-size: 0.9rem;">{{ $buku->isbn ?: 'Belum tersedia' }}</div>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted" style="font-size: 0.75rem;">Penerbit</small>
                    <div class="fw-bold text-break" style="font-size: 0.9rem;">{{ $buku->penerbit ?? '-' }}</div>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted" style="font-size: 0.75rem;">Stok</small>
                    <div class="fw-bold" style="font-size: 0.9rem;">{{ $buku->stok ?? 0 }} eksemplar</div>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted" style="font-size: 0.75rem;">Status</small>
                    <div class="fw-bold" style="font-size: 0.9rem; color: {{ ($buku->stok ?? 0) > 0 ? '#10b981' : '#f59e0b' }};">
                        {{ ($buku->stok ?? 0) > 0 ? 'Tersedia' : 'Dipinjam' }}
                    </div>
                </div>
            </div>

            @if(!empty($buku->sinopsis))
                <h5 class="fw-bold mb-3" style="font-size: 1.1rem;"><i class="bi bi-list-ul"></i> Sinopsis</h5>
                <p class="text-muted" style="line-height: 1.8; font-size: 0.95rem;">{{ $buku->sinopsis }}</p>
            @else
                <div class="alert alert-light border mt-4" role="status">
                    <i class="bi bi-info-circle me-1"></i>
                    Sinopsis buku ini belum ditambahkan.
                </div>
            @endif

            <!-- Ketentuan Peminjaman -->
            <div class="card mt-4" style="border: 1px solid #fcd34d; border-radius: 12px; padding: 20px; background: #fffbeb;">
                <h6 class="fw-bold mb-2" style="font-size: 0.95rem;"><i class="bi bi-info-circle" style="color: #f59e0b;"></i> Ketentuan Peminjaman Anggota Siswa:</h6>
                <p class="mb-0" style="font-size: 0.85rem; color: var(--text-dark); line-height: 1.6;">
                    Untuk meminjam buku, silakan hubungi petugas perpustakaan. Lama pinjam dan denda mengikuti kebijakan yang berlaku.
                </p>
            </div>

            <!-- Tombol Aksi - RESPONSIVE -->
            <div class="d-flex gap-2 mt-4 flex-column flex-sm-row">
                <a href="{{ route('publik.katalog') }}" class="btn text-center" style="background: var(--primary-blue); color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 0.9rem;">
                    <i class="bi bi-arrow-left"></i> Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>

    @if($rekomendasi->isNotEmpty())
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <small style="color: var(--primary-blue); font-weight: 600; font-size: 0.85rem;">TOPIK SERUPA</small>
                <h3 class="fw-bold mb-0" style="font-size: clamp(1.1rem, 3vw, 1.5rem);">Rekomendasi Buku Terkait</h3>
            </div>
            <a href="{{ route('publik.katalog') }}" style="color: var(--primary-blue); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <!-- RESPONSIVE GRID: 2 di HP, 3 di tablet, 4 di desktop -->
        <div class="row g-3 g-md-4">
            @foreach($rekomendasi as $bukuRec)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card-buku">
                    <div class="card-buku-cover" style="height: 160px;">
                        @if($bukuRec->cover)
                            <img src="{{ asset('storage/'.$bukuRec->cover) }}" alt="{{ $bukuRec->judul }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <i class="bi bi-book" style="display: none; font-size: 48px;"></i>
                        @else
                            <i class="bi bi-book" style="font-size: 48px;"></i>
                        @endif
                        <span class="{{ $bukuRec->stok > 0 ? 'badge-tersedia' : 'badge-dipinjam' }}">{{ $bukuRec->stok > 0 ? 'Tersedia' : 'Stok habis' }}</span>
                    </div>
                    <div class="card-buku-body">
                        <div style="font-size: 10px; color: var(--primary-blue); font-weight: 600;">{{ $bukuRec->kategori ?? 'Umum' }}</div>
                        <div class="card-buku-title mt-1" style="font-size: 12px; line-height: 1.3;">{{ Str::limit($bukuRec->judul, 30) }}</div>
                        <div class="card-buku-author" style="font-size: 10px;">{{ Str::limit($bukuRec->penulis, 25) }}</div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted" style="font-size: 9px;"><i class="bi bi-box-seam"></i> {{ $bukuRec->stok }} eks</small>
                            <a href="{{ route('publik.detail', $bukuRec->id_buku) }}" style="color: var(--primary-blue); font-size: 11px; font-weight: 600; text-decoration: none;">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
/* Responsive adjustments for detail buku */
@media (max-width: 768px) {
    .card-buku-cover {
        height: 140px !important;
    }
    
    .card-buku-title {
        font-size: 11px !important;
    }
    
    .card-buku-author {
        font-size: 9px !important;
    }
    
    .badge-tersedia {
        font-size: 9px !important;
        padding: 2px 6px !important;
    }
}

@media (max-width: 576px) {
    .card-buku-cover {
        height: 120px !important;
    }
    
    .btn {
        font-size: 0.85rem !important;
        padding: 10px 16px !important;
    }
}
</style>
@endpush