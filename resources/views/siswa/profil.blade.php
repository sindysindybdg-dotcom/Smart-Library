@extends('layouts.siswa')

@section('title', 'Profil Siswa')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('siswa.dashboard') }}">Beranda</a> / 
    <strong>Profil Saya</strong>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <small class="text-muted">Portal Siswa Resmi • Smart Library</small>
        <h2 class="fw-bold mb-1" style="font-size: clamp(1.25rem, 4vw, 1.75rem);">Profil Anggota Perpustakaan</h2>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">Informasi data diri keanggotaan dan kartu perpustakaan digital.</p>
    </div>
    <span class="badge bg-success"><i class="bi bi-circle-fill" style="font-size: 8px;"></i> Akun Aktif</span>
</div>

<div class="row g-3 g-md-4">
    <!-- KOLOM KIRI: KARTU ANGGOTA & STATUS -->
    <div class="col-12 col-lg-4">
        <div class="kartu-anggota card-custom p-3 p-md-4" style="background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; border-radius: 16px;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <strong class="d-block" style="font-size: 1rem;">SMK BUDI BAKTI CIWIDEY</strong>
                    <small style="opacity: 0.9; font-size: 0.75rem;">KARTU PERPUSTAKAAN DIGITAL</small>
                </div>
                <span class="badge bg-light text-primary">SMARTLIB</span>
            </div>
            
            <div class="d-flex gap-3 align-items-center mb-3">
                <div style="width: 70px; height: 70px; min-width: 70px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #1e40af; flex-shrink: 0;">
                    <i class="bi bi-person" style="font-size: 36px;"></i>
                </div>
                <div class="text-break">
                    <h3 class="fw-bold mb-1" style="color: white; font-size: 1.1rem;">{{ $dataProfil['nama'] ?? 'Nama Siswa' }}</h3>
                    <p class="mb-0" style="opacity: 0.9; font-size: 0.9rem;">{{ $dataProfil['kelas'] ?? '-' }}</p>
                    <small style="opacity: 0.8; font-size: 0.75rem;">{{ $dataProfil['program_keahlian'] ?? '-' }}</small>
                </div>
            </div>

            <div class="row g-2 mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.2);">
                <div class="col-6">
                    <small style="opacity: 0.8; font-size: 0.7rem;">NO. ANGGOTA</small>
                    <div class="fw-bold" style="color: white; font-size: 0.9rem; word-break: break-all;">{{ $dataProfil['no_anggota'] ?? '-' }}</div>
                </div>
                <div class="col-6">
                    <small style="opacity: 0.8; font-size: 0.7rem;">NISN</small>
                    <div class="fw-bold" style="color: white; font-size: 0.9rem;">{{ $dataProfil['nisn'] ?? '-' }}</div>
                </div>
            </div>

            <div class="mt-3 text-center" style="background: white; padding: 10px; border-radius: 8px;">
                <i class="bi bi-upc-scan text-dark" style="font-size: 32px;"></i>
                <div class="small text-dark fw-bold mt-1" style="font-size: 0.85rem;">{{ $dataProfil['nisn'] ?? '-' }}</div>
                <small class="text-muted" style="font-size: 0.7rem;">BARCODE SIRKULASI</small>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
            <button class="btn btn-outline-primary flex-fill btn-sm"><i class="bi bi-download"></i> <span class="d-none d-sm-inline">Unduh</span> PDF</button>
            <button class="btn btn-outline-primary flex-fill btn-sm"><i class="bi bi-printer"></i> <span class="d-none d-sm-inline">Cetak</span> Kartu</button>
        </div>

        <!-- STATUS KEANGGOTAAN -->
        <div class="card-custom p-3 mt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title mb-0" style="font-size: 0.95rem;"><i class="bi bi-person-check text-primary"></i> Status Keanggotaan</h6>
                <span class="badge bg-success">Aktif</span>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-muted" style="font-size: 0.8rem;">Tanggal Registrasi</small>
                    <strong style="font-size: 0.85rem;">{{ $dataProfil['tanggal_registrasi'] ?? '-' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-muted" style="font-size: 0.8rem;">No. Anggota</small>
                    <strong style="font-size: 0.85rem;">{{ $dataProfil['no_anggota'] ?? '-' }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-muted" style="font-size: 0.8rem;">Status Dapodik</small>
                    <strong class="text-success" style="font-size: 0.85rem;"><i class="bi bi-check-circle"></i> Valid</strong>
                </div>
            </div>
        </div>

        <!-- PEMINJAMAN BERJALAN -->
        @if(isset($statsBaca['aktif']) && $statsBaca['aktif'])
        <div class="card-custom p-3 mt-3">
            <h6 class="card-title mb-3" style="font-size: 0.95rem;"><i class="bi bi-book text-primary"></i> Peminjaman Berjalan</h6>
            <div class="d-flex align-items-center gap-3">
                <div style="width: 50px; height: 70px; min-width: 50px; background: linear-gradient(135deg, #1e40af, #3b82f6); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
                    <i class="bi bi-book" style="font-size: 24px;"></i>
                </div>
                <div class="flex-grow-1 text-break">
                    <span class="badge bg-warning text-dark mb-1" style="font-size: 0.7rem;">Pinjaman Berjalan</span>
                    <div class="fw-bold" style="font-size: 0.85rem;">{{ Str::limit($statsBaca['aktif']->judul ?? 'Buku', 30) }}</div>
                    @php
                        $jatuhTempo = \Carbon\Carbon::parse($statsBaca['aktif']->tanggal_kembali);
                        $sisaHari = now()->diffInDays($jatuhTempo, false);
                    @endphp
                    <small class="{{ $sisaHari <= 2 ? 'text-danger' : 'text-muted' }}" style="font-size: 0.75rem;">
                        Jatuh tempo: <strong>{{ $jatuhTempo->format('d M Y') }}</strong> ({{ $sisaHari }} hari lagi)
                    </small>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- KOLOM KANAN: DATA PRIBADI & KONTAK -->
    <div class="col-12 col-lg-8">
        <!-- DATA PRIBADI -->
        <div class="card-custom p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="card-title mb-0" style="font-size: 1.1rem;"><i class="bi bi-person-vcard text-primary"></i> Data Pribadi & Akademik</h5>
                <span class="badge bg-secondary"><i class="bi bi-lock"></i> Data Terkunci</span>
            </div>
            <small class="text-muted d-block mb-3" style="font-size: 0.8rem;">Data keanggotaan perpustakaan SMK Budi Bakti Ciwidey</small>
            
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="small text-muted" style="font-size: 0.75rem;">Nama Lengkap</label>
                    <div class="fw-bold text-break" style="font-size: 0.95rem;">{{ $dataProfil['nama'] ?? '-' }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="small text-muted" style="font-size: 0.75rem;">NISN / Nomor Induk</label>
                    <div class="fw-bold text-break" style="font-size: 0.95rem;">{{ $dataProfil['nisn'] ?? '-' }} <span class="badge bg-success ms-2" style="font-size: 0.65rem;">Tervalidasi</span></div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="small text-muted" style="font-size: 0.75rem;">Tipe Keanggotaan</label>
                    <div class="fw-bold" style="font-size: 0.95rem;">Siswa Reguler</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="small text-muted" style="font-size: 0.75rem;">Kelas</label>
                    <div class="fw-bold text-primary" style="font-size: 0.95rem;">{{ $dataProfil['kelas'] ?? '-' }}</div>
                </div>
                <div class="col-12">
                    <label class="small text-muted" style="font-size: 0.75rem;">Program Keahlian</label>
                    <div class="fw-bold" style="font-size: 0.95rem;">{{ $dataProfil['program_keahlian'] ?? '-' }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="small text-muted" style="font-size: 0.75rem;">Jenis Kelamin</label>
                    <div class="fw-bold" style="font-size: 0.95rem;">{{ $dataProfil['jenis_kelamin'] ?? '-' }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="small text-muted" style="font-size: 0.75rem;">Tempat, Tanggal Lahir</label>
                    <div class="fw-bold text-break" style="font-size: 0.95rem;">{{ $dataProfil['tempat_lahir'] ?? '-' }}, {{ $dataProfil['tanggal_lahir'] ?? '-' }}</div>
                </div>
                <div class="col-12">
                    <label class="small text-muted" style="font-size: 0.75rem;">Alamat Domisili</label>
                    <div class="fw-bold text-break" style="font-size: 0.95rem;">{{ $dataProfil['alamat'] ?? '-' }}</div>
                </div>
            </div>

            <div class="alert alert-info mt-3 mb-0 small" style="font-size: 0.8rem;">
                <i class="bi bi-info-circle"></i> Jika terdapat kesalahan penulisan data akademik, silakan hubungi operator Tata Usaha (TU) atau staf sirkulasi perpustakaan.
            </div>
        </div>

        <!-- KONTAK & NOTIFIKASI -->
        <div class="card-custom p-3 p-md-4 mt-4">
            <h5 class="card-title mb-3" style="font-size: 1.1rem;"><i class="bi bi-bell text-primary"></i> Kontak & Notifikasi</h5>
            <small class="text-muted d-block mb-3" style="font-size: 0.8rem;">Pemberitahuan otomatis saat buku mendekati tanggal jatuh tempo</small>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="small text-muted" style="font-size: 0.75rem;">Nomor WhatsApp</label>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <strong class="text-break" style="font-size: 0.95rem;">{{ $dataProfil['whatsapp'] ?? '-' }}</strong>
                        @if(!empty($dataProfil['whatsapp']) && $dataProfil['whatsapp'] !== '-')
                            <span class="badge bg-success" style="font-size: 0.7rem;">Terhubung</span>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="small text-muted" style="font-size: 0.75rem;">Email Aktif</label>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <strong class="text-break" style="font-size: 0.95rem;">{{ $dataProfil['email'] ?? '-' }}</strong>
                        @if(!empty($dataProfil['email']) && $dataProfil['email'] !== '-')
                            <span class="badge bg-primary" style="font-size: 0.7rem;">Aktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <hr>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" checked id="notifCheck">
                <label class="form-check-label" for="notifCheck" style="font-size: 0.85rem;">
                    <strong>Status Pengingat: Aktif</strong><br>
                    <small class="text-muted">Kirim pengingat harian untuk buku yang belum dikembalikan.</small>
                </label>
            </div>
        </div>

        <!-- STATISTIK MEMBACA -->
        @php
            $kepatuhan = ($statsBaca['total'] ?? 0) > 0 ? round((($statsBaca['total'] - $statsBaca['terlambat']) / $statsBaca['total']) * 100) : 100;
        @endphp

        <div class="card-custom p-3 p-md-4 mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="card-title mb-0" style="font-size: 1.1rem;"><i class="bi bi-graph-up text-primary"></i> Statistik Membaca</h5>
                <span class="badge bg-primary" style="font-size: 0.75rem;">{{ $kepatuhan >= 80 ? 'Rajin' : ($kepatuhan >= 50 ? 'Cukup' : 'Kurang') }}</span>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="p-3 border rounded h-100 text-center text-md-start">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted" style="font-size: 0.75rem;">Buku Dipinjam</span>
                            <i class="bi bi-book text-primary"></i>
                        </div>
                        <div class="fw-bold" style="font-size: 1.5rem;">{{ $statsBaca['total'] ?? 0 }} <small class="text-muted" style="font-size: 0.8rem;">Buku</small></div>
                        <small class="text-success" style="font-size: 0.75rem;">Sepanjang masa keanggotaan</small>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3 border rounded h-100 text-center text-md-start">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted" style="font-size: 0.75rem;">Kategori Favorit</span>
                            <i class="bi bi-pie-chart text-primary"></i>
                        </div>
                        <div class="fw-bold text-break" style="font-size: 1.1rem;">{{ strtoupper($statsBaca['kategori_favorit'] ?? 'Umum') }}</div>
                        <small class="text-muted" style="font-size: 0.75rem;">Berdasarkan riwayat</small>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3 border rounded h-100 text-center text-md-start">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted" style="font-size: 0.75rem;">Kepatuhan Waktu</span>
                            <i class="bi bi-clock {{ $kepatuhan >= 80 ? 'text-success' : 'text-warning' }}"></i>
                        </div>
                        <div class="fw-bold {{ $kepatuhan >= 80 ? 'text-success' : 'text-warning' }}" style="font-size: 1.5rem;">{{ $kepatuhan }}% <small style="font-size: 0.8rem;">Tepat Waktu</small></div>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $statsBaca['terlambat'] ?? 0 }}x terlambat</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- KEAMANAN AKUN -->
        <div class="card-custom p-3 p-md-4 mt-4">
            <h5 class="card-title mb-3" style="font-size: 1.1rem;"><i class="bi bi-shield-lock text-primary"></i> Keamanan Akun</h5>
            <small class="text-muted d-block mb-3" style="font-size: 0.8rem;">Kelola kata sandi masuk untuk keamanan akun perpustakaan Anda</small>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label" style="font-size: 0.8rem;">Username Login</label>
                        <input type="text" class="form-control" value="{{ $user->username ?? '-' }}" readonly style="font-size: 0.9rem; background-color: #f8fafc;">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" style="font-size: 0.8rem;">Nama Akun</label>
                        <input type="text" class="form-control" value="{{ $user->nama ?? '-' }}" readonly style="font-size: 0.9rem; background-color: #f8fafc;">
                    </div>
                </div>
                <hr>
                <small class="text-muted d-block mb-2" style="font-size: 0.8rem;">Untuk mengganti kata sandi, silakan hubungi petugas perpustakaan.</small>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout dari Akun Ini</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection