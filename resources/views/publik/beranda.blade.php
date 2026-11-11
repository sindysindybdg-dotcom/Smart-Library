@extends('layouts.publik')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); padding: 40px 0 60px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-7">
                <small style="color: var(--primary-blue); font-weight: 600; font-size: 0.85rem;">
                    <i class="bi bi-stars"></i> Perpustakaan Pintar Generasi Vokasi
                </small>
                <h1 style="font-size: clamp(1.75rem, 5vw, 3rem); font-weight: 900; line-height: 1.2; margin: 16px 0;">
                    Temukan Jendela Dunia di Perpustakaan Digital 
                    <span style="color: var(--primary-blue);">SMK Budi Bakti</span>
                </h1>
                <p class="text-muted" style="font-size: clamp(0.9rem, 2vw, 1rem); line-height: 1.6;">
                    Akses mudah dan terpadu ke ribuan referensi vokasi, literatur umum, hingga modul pembelajaran kurikulum merdeka. Siapkan potensi terbaikmu dari sini.
                </p>

                <!-- Search Box Hero - RESPONSIVE -->
                <form action="{{ route('publik.katalog') }}" method="GET" class="mt-4" style="background: white; padding: 8px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <div class="d-flex align-items-center gap-2 flex-grow-1" style="padding: 8px 16px; background: #f8fafc; border-radius: 8px;">
                            <i class="bi bi-search" style="color: var(--text-muted);"></i>
                            <input type="text" name="q" class="form-control border-0 bg-transparent" style="outline: none; font-size: 14px;" placeholder="Ketik judul buku, pengarang, atau ISBN...">
                        </div>
                        <button type="submit" class="btn text-nowrap" style="background: var(--primary-blue); color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                            Cari Koleksi <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- Kategori Populer -->
                <div class="mt-3">
                    <small class="text-muted" style="font-size: 0.8rem;">Kategori Populer:</small>
                    <div class="d-flex gap-2 mt-2 flex-wrap">
                        <span class="badge" style="background: white; color: var(--primary-blue); border: 1px solid var(--border-color); padding: 6px 12px; font-size: 11px;">RPL / PPLG</span>
                        <span class="badge" style="background: white; color: var(--primary-blue); border: 1px solid var(--border-color); padding: 6px 12px; font-size: 11px;">Teknik Komputer</span>
                        <span class="badge" style="background: white; color: var(--primary-blue); border: 1px solid var(--border-color); padding: 6px 12px; font-size: 11px;">Fiksi</span>
                        <span class="badge" style="background: white; color: var(--primary-blue); border: 1px solid var(--border-color); padding: 6px 12px; font-size: 11px;">Sains</span>
                        <span class="badge" style="background: white; color: var(--primary-blue); border: 1px solid var(--border-color); padding: 6px 12px; font-size: 11px;">Sejarah</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <i class="bi bi-journal-bookmark" style="font-size: 200px; color: var(--primary-blue); opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Statistik -->
<section style="padding: 40px 0;">
    <div class="container">
        <div class="row g-3 g-md-4">
            <div class="col-12 col-md-4">
                <div class="card-custom" style="background: white; border-radius: 12px; border: 1px solid var(--border-color); padding: 20px; display: flex; align-items: center; gap: 16px; height: 100%;">
                    <div style="width: 56px; height: 56px; min-width: 56px; background: var(--accent-blue); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-journal-bookmark" style="font-size: 28px; color: var(--primary-blue);"></i>
                    </div>
                    <div>
                        <div data-stat="books" style="font-size: 28px; font-weight: 800; color: var(--primary-blue);">{{ number_format($totalBuku, 0, ',', '.') }}</div>
                        <div style="font-size: 13px; font-weight: 600;">Koleksi Judul Buku</div>
                        <small class="text-muted" style="font-size: 0.75rem;">Judul yang tercatat di katalog</small>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-custom" style="background: white; border-radius: 12px; border: 1px solid var(--border-color); padding: 20px; display: flex; align-items: center; gap: 16px; height: 100%;">
                    <div style="width: 56px; height: 56px; min-width: 56px; background: #dcfce7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people" style="font-size: 28px; color: #10b981;"></i>
                    </div>
                    <div>
                        <div data-stat="active-members" style="font-size: 28px; font-weight: 800; color: #10b981;">{{ number_format($totalAnggotaAktif, 0, ',', '.') }}</div>
                        <div style="font-size: 13px; font-weight: 600;">Anggota Aktif</div>
                        <small class="text-muted" style="font-size: 0.75rem;">Anggota dengan status aktif</small>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-custom" style="background: white; border-radius: 12px; border: 1px solid var(--border-color); padding: 20px; display: flex; align-items: center; gap: 16px; height: 100%;">
                    <div style="width: 56px; height: 56px; min-width: 56px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-lightning-charge" style="font-size: 28px; color: #f59e0b;"></i>
                    </div>
                    <div>
                        <div style="font-size: 20px; font-weight: 800; color: #f59e0b;">Praktis & Cepat</div>
                        <div style="font-size: 13px; font-weight: 600;">Sistem Peminjaman</div>
                        <small class="text-muted" style="font-size: 0.75rem;">Cek ketersediaan tanpa antre manual</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Koleksi Terbaru & Populer -->
<section style="padding: 40px 0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <small style="color: var(--primary-blue); font-weight: 600; font-size: 0.85rem;">
                    <i class="bi bi-stars"></i> Rekomendasi Pilihan
                </small>
                <h2 class="fw-bold mb-1" style="font-size: clamp(1.25rem, 4vw, 1.75rem);">Koleksi Buku Terbaru & Populer</h2>
                <p class="text-muted mb-0" style="font-size: 0.875rem;">Jelajahi buku pelajaran, teknologi industri terkini, serta karya sastra favorit siswa.</p>
            </div>
            <a href="{{ route('publik.katalog') }}" style="color: var(--primary-blue); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                Buka Katalog Lengkap <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <!-- RESPONSIVE GRID: 2 di HP, 3 di tablet, 4 di desktop -->
        <div class="row g-3 g-md-4">
            @forelse($bukusPopuler as $buku)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card-buku">
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
                            <span class="badge-tersedia">Tersedia</span>
                        @else
                            <span class="badge-dipinjam">Dipinjam</span>
                        @endif
                    </div>
                    
                    <div class="card-buku-body">
                        <div class="card-buku-meta">
                            <span style="font-size: 10px;"><i class="bi bi-bookmark"></i> {{ $buku->kategori ?? 'Umum' }}</span>
                            <span style="font-size: 10px;">Stok: {{ $buku->stok ?? 0 }}</span>
                        </div>
                        <div class="card-buku-title" style="font-size: 13px;">{{ Str::limit($buku->judul ?? 'Judul Buku', 35) }}</div>
                        <div class="card-buku-author" style="font-size: 11px;">{{ Str::limit($buku->penulis ?? 'Penulis', 25) }}</div>
                        <a href="{{ route('publik.detail', $buku->id_buku) }}" class="btn-detail" style="font-size: 11px; padding: 6px 12px;">
                            Detail <i class="bi bi-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <i class="bi bi-inbox" style="font-size: 48px; color: #94a3b8;"></i>
                <p class="text-muted mt-2">Belum ada buku populer yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Cara Meminjam -->
<section style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); padding: 50px 0;">
    <div class="container">
        <div class="text-center mb-5">
            <small style="color: var(--primary-blue); font-weight: 600; font-size: 0.85rem;">Alur Layanan Cepat</small>
            <h2 class="fw-bold" style="font-size: clamp(1.25rem, 4vw, 1.75rem);">Cara Mudah Meminjam Buku</h2>
            <p class="text-muted mb-0" style="font-size: 0.9rem; max-width: 600px; margin: 0 auto;">
                Peminjaman pustaka di SMK Budi Bakti Ciwidey dirancang teratur, transparan, dan tanpa proses berbelit.
            </p>
        </div>

        <div class="row g-3 g-md-4">
            <div class="col-12 col-md-4">
                <div class="card" style="border: none; border-radius: 12px; padding: 24px; height: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <div style="width: 48px; height: 48px; background: var(--primary-blue); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px; margin-bottom: 16px;">01</div>
                    <h5 class="fw-bold" style="font-size: 1.1rem;">Cari Buku di Katalog</h5>
                    <p class="text-muted small" style="font-size: 0.85rem;">Gunakan fitur pencarian online Smart Library untuk memastikan ketersediaan eksemplar dan mencatat nomor kode rak buku.</p>
                    <small style="color: var(--primary-blue); font-size: 0.75rem;"><i class="bi bi-phone"></i> Akses via smartphone / laptop</small>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card" style="border: none; border-radius: 12px; padding: 24px; height: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <div style="width: 48px; height: 48px; background: var(--primary-blue); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px; margin-bottom: 16px;">02</div>
                    <h5 class="fw-bold" style="font-size: 1.1rem;">Kunjungi Petugas</h5>
                    <p class="text-muted small" style="font-size: 0.85rem;">Ambil buku di rak yang sesuai atau langsung menuju meja sirkulasi untuk verifikasi fisik oleh pustakawan sekolah.</p>
                    <small style="color: var(--primary-blue); font-size: 0.75rem;"><i class="bi bi-geo-alt"></i> Ruang Perpustakaan Lt. 2</small>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card" style="border: none; border-radius: 12px; padding: 24px; height: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <div style="width: 48px; height: 48px; background: #f59e0b; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px; margin-bottom: 16px;">03</div>
                    <h5 class="fw-bold" style="font-size: 1.1rem;">Tunjukkan Kartu Anggota</h5>
                    <p class="text-muted small" style="font-size: 0.85rem;">Pindai barcode kartu siswa atau sebutkan NISN. Peminjaman otomatis terekam dan pengembalian terpantau rapi.</p>
                    <small style="color: #f59e0b; font-size: 0.75rem;"><i class="bi bi-clock"></i> Durasi peminjaman 7 hari</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Daftar Anggota -->
<section style="padding: 50px 0;">
    <div class="container">
        <div style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border-radius: 16px; padding: 32px 48px; color: white;">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <small style="opacity: 0.9; font-size: 0.85rem;"><i class="bi bi-patch-check"></i> Khusus Civitas SMK Budi Bakti Ciwidey</small>
                    <h2 class="fw-bold mt-2" style="font-size: clamp(1.25rem, 4vw, 1.75rem);">Belum Memiliki Akun Anggota Perpustakaan?</h2>
                    <p style="opacity: 0.9; font-size: 0.9rem; margin-bottom: 0;">
                        Daftarkan diri secara mandiri dengan NISN atau NIP untuk menikmati kemudahan bookmark buku, perpanjangan masa pinjam online, dan rekomendasi berkala.
                    </p>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="d-flex flex-column flex-lg-row gap-2 justify-content-lg-end">
                        <a href="{{ route('register') }}" class="btn text-nowrap" style="background: white; color: var(--primary-blue); padding: 12px 20px; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                            Daftar Anggota <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ route('publik.panduan') }}" class="btn text-nowrap" style="background: transparent; color: white; border: 1px solid white; padding: 12px 20px; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                            Tata Tertib <i class="bi bi-info-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Responsive adjustments for beranda */
@media (max-width: 768px) {
    .card-buku-cover {
        height: 160px !important;
    }
    
    .card-buku-title {
        font-size: 12px !important;
    }
    
    .card-buku-author {
        font-size: 10px !important;
    }
    
    .btn-detail {
        font-size: 10px !important;
        padding: 5px 10px !important;
    }
    
    .card-custom {
        padding: 16px !important;
    }
}

@media (max-width: 576px) {
    .card-buku-cover {
        height: 140px !important;
    }
    
    .badge-tersedia, .badge-dipinjam {
        font-size: 9px !important;
        padding: 2px 6px !important;
    }
}
</style>
@endpush