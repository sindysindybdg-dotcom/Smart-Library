@extends('layouts.siswa')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('siswa.dashboard') }}">Beranda</a> / 
    <strong>Riwayat Peminjaman</strong>
</div>

<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <span class="badge bg-primary mb-2">AREA SISWA PERPUSTAKAAN</span>
        <h2 class="fw-bold mb-1" style="font-size: clamp(1.25rem, 4vw, 1.75rem);">Riwayat Peminjaman Buku</h2>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">Pantau status peminjaman aktif, batas jatuh tempo, dan histori sirkulasi koleksi Anda.</p>
    </div>
    <div class="card-custom mb-0 p-3 w-100 w-md-auto" style="min-width: 250px; max-width: 100%;">
        <div class="d-flex align-items-center gap-3">
            <div style="width: 48px; height: 48px; min-width: 48px; background: var(--accent-blue, #e0f2fe); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-book" style="font-size: 24px; color: var(--primary-blue, #0284c7);"></i>
            </div>
            <div>
                <small class="text-muted" style="font-size: 0.75rem;">Sisa Kuota Peminjaman</small>
                <div class="fw-bold" style="font-size: 0.95rem;">{{ max(0, 3 - ($stats['dipinjam'] ?? 0)) }} / 3 Buku</div>
                <div class="progress-custom mt-1" style="height: 6px; background: #e2e8f0; border-radius: 3px;">
                    <div class="progress-bar-custom" style="width: {{ (($stats['dipinjam'] ?? 0) / 3) * 100 }}%; height: 100%; background: var(--primary-blue, #0284c7); border-radius: 3px; transition: width 0.3s;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATISTIK DINAMIS -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="stat-box card-custom p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label text-muted" style="font-size: 0.8rem;">Sedang Dipinjam</div>
                    <div class="stat-value fw-bold fs-4">{{ $stats['dipinjam'] ?? 0 }} <small class="text-muted" style="font-size: 14px;">Buku</small></div>
                </div>
                <i class="bi bi-hourglass-split" style="font-size: 32px; color: var(--warning-orange, #f59e0b);"></i>
            </div>
            @if(($stats['dipinjam'] ?? 0) > 0)
            <div class="alert-warning-custom mt-3 mb-0 p-2 rounded" style="background: #fffbeb; border: 1px solid #fcd34d;">
                <i class="bi bi-exclamation-triangle text-warning"></i>
                <small style="font-size: 0.75rem;"><strong>Perhatian:</strong> Segera kembalikan sebelum jatuh tempo.</small>
            </div>
            @endif
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-box card-custom p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label text-muted" style="font-size: 0.8rem;">Sudah Dikembalikan</div>
                    <div class="stat-value fw-bold fs-4">{{ $stats['dikembalikan'] ?? 0 }} <small class="text-muted" style="font-size: 14px;">Buku</small></div>
                </div>
                <i class="bi bi-check-circle" style="font-size: 32px; color: var(--success-green, #10b981);"></i>
            </div>
            <small class="text-success mt-3 d-block" style="font-size: 0.75rem;"><i class="bi bi-check-circle"></i> Riwayat pengembalian tercatat baik.</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-box card-custom p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label text-muted" style="font-size: 0.8rem;">Total Riwayat Denda</div>
                    <div class="stat-value fw-bold fs-4">Rp{{ number_format($stats['total_denda'] ?? 0, 0, ',', '.') }} <small class="text-muted" style="font-size: 14px;">/ {{ $stats['terlambat'] ?? 0 }}</small></div>
                </div>
                <i class="bi bi-receipt" style="font-size: 32px; color: var(--primary-blue, #0284c7);"></i>
            </div>
            <small class="mt-3 d-block {{ ($stats['total_denda'] ?? 0) == 0 ? 'text-success' : 'text-danger' }}" style="font-size: 0.75rem;">
                <i class="bi bi-{{ ($stats['total_denda'] ?? 0) == 0 ? 'check-circle' : 'exclamation-circle' }}"></i> 
                {{ ($stats['total_denda'] ?? 0) == 0 ? 'Bebas Tunggakan' : 'Ada tunggakan belum diselesaikan' }}
            </small>
        </div>
    </div>
</div>

<!-- PEMINJAMAN AKTIF (DINAMIS) -->
@php
    $peminjamanAktif = collect($riwayat)->filter(function($item) {
        $status = strtolower($item->status ?? '');
        return in_array($status, ['dipinjam', 'terlambat', 'aktif']);
    });
@endphp

@if($peminjamanAktif->isNotEmpty())
<div class="card-custom p-3 p-md-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="card-title mb-0" style="font-size: 1.1rem;"><i class="bi bi-bookmark-check text-primary"></i> Peminjaman Aktif Saat Ini</h5>
        <span class="badge bg-primary">{{ $peminjamanAktif->count() }} Buku Sedang Dipinjam</span>
    </div>

    @foreach($peminjamanAktif as $item)
    <div class="row g-3 align-items-center border-bottom pb-4 mb-4 last-child-no-border">
        <div class="col-12 col-md-2">
            <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #1e40af, #3b82f6); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; position: relative; overflow: hidden;">
                @if(!empty($item->cover))
                    <img src="{{ asset('storage/' . $item->cover) }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'">
                @endif
                <i class="bi bi-book" style="font-size: 40px; position: absolute;"></i>
            </div>
        </div>
        <div class="col-12 col-md-10">
            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                <div class="text-break">
                    <span class="badge bg-warning text-dark mb-1" style="font-size: 0.7rem;">Dipinjam</span>
                    <h5 class="fw-bold mb-1" style="font-size: 1.1rem;">{{ Str::limit($item->judul ?? 'Judul Tidak Diketahui', 50) }}</h5>
                    <small class="text-muted" style="font-size: 0.8rem;">Penulis: {{ $item->penulis ?? '-' }}</small>
                </div>
                <small class="text-muted" style="font-size: 0.8rem;">ID: <strong>#{{ $item->id_peminjaman ?? $item->id }}</strong></small>
            </div>

            <div class="row g-2 mt-3">
                <div class="col-6 col-md-3">
                    <small class="text-muted" style="font-size: 0.7rem;">TANGGAL PINJAM</small>
                    <div class="fw-bold" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</div>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted" style="font-size: 0.7rem;">JATUH TEMPO</small>
                    <div class="fw-bold text-danger" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($item->tanggal_kembali ?? $item->jatuh_tempo)->format('d M Y') }}</div>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted" style="font-size: 0.7rem;">DENDA SAAT INI</small>
                    <div class="fw-bold {{ ($item->denda ?? 0) > 0 ? 'text-danger' : 'text-success' }}" style="font-size: 0.9rem;">
                        Rp{{ number_format($item->denda ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div class="col-6 col-md-3 d-flex align-items-end">
                    <a href="{{ route('publik.detail', $item->id_buku ?? $item->buku_id) }}" class="btn btn-primary-custom btn-sm w-100" style="font-size: 0.8rem;">
                        <i class="bi bi-book"></i> Detail Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- RIWAYAT TRANSAKSI LENGKAP (TABEL DINAMIS) -->
<div class="card-custom p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="card-title mb-0" style="font-size: 1.1rem;"><i class="bi bi-clock-history text-primary"></i> Riwayat Transaksi Lengkap</h5>
    </div>
    <small class="text-muted d-block mb-3" style="font-size: 0.8rem;">Daftar semua sirkulasi koleksi yang pernah Anda pinjam.</small>

    <div class="table-responsive">
        <table class="table table-hover align-middle" style="font-size: 0.85rem;">
            <thead class="table-light">
                <tr>
                    <th class="text-nowrap">ID</th>
                    <th>JUDUL BUKU</th>
                    <th class="text-nowrap">PINJAM</th>
                    <th class="text-nowrap">JATUH TEMPO</th>
                    <th class="text-nowrap">KEMBALI</th>
                    <th class="text-nowrap">DENDA</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $item)
                @php
                    $statusLower = strtolower($item->status ?? '');
                    $isLate = ($item->denda ?? 0) > 0;
                    $isReturned = in_array($statusLower, ['dikembalikan', 'kembali', 'selesai']);
                @endphp
                <tr>
                    <td class="text-nowrap"><strong class="text-primary">#{{ $item->id_peminjaman ?? $item->id }}</strong></td>
                    <td>
                        <strong class="text-break">{{ Str::limit($item->judul ?? 'Buku', 25) }}</strong><br>
                        <small class="text-muted">{{ $item->penulis ?? '-' }}</small>
                    </td>
                    <td class="text-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td class="text-nowrap {{ $isLate && !$isReturned ? 'text-danger fw-bold' : '' }}">
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali ?? $item->jatuh_tempo)->format('d/m/Y') }}
                    </td>
                    <td class="text-nowrap">
                        @if($isReturned && !empty($item->tanggal_pengembalian))
                            <span class="text-success">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-nowrap {{ $isLate ? 'text-danger fw-bold' : '' }}">
                        Rp{{ number_format($item->denda ?? 0, 0, ',', '.') }}
                    </td>
                    <td>
                        @if(in_array($statusLower, ['dipinjam', 'aktif', 'terlambat']))
                                    <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">{{ $statusLower === 'terlambat' ? 'Terlambat' : 'Dipinjam' }}</span>
                        @elseif($isReturned)
                            @if($isLate)
                                <span class="badge bg-danger" style="font-size: 0.7rem;">Terlambat</span>
                            @else
                                <span class="badge bg-success" style="font-size: 0.7rem;">Kembali</span>
                            @endif
                        @else
                            <span class="badge bg-secondary" style="font-size: 0.7rem;">{{ $item->status ?? 'Unknown' }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 48px;"></i>
                        <p class="mt-2">Belum ada riwayat peminjaman.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- KETENTUAN PEMINJAMAN -->
<div class="card-custom p-3 p-md-4 mt-4">
    <h5 class="card-title mb-3" style="font-size: 1.1rem;"><i class="bi bi-shield-check text-primary"></i> Ketentuan Peminjaman</h5>
    <div class="row g-3">
        <div class="col-12 col-md-3">
            <div class="p-3 border rounded h-100 bg-light">
                <i class="bi bi-calendar-check" style="font-size: 24px; color: var(--primary-blue, #0284c7);"></i>
                <div class="fw-bold mt-2" style="font-size: 0.95rem;">Durasi Maks</div>
                <small class="text-muted" style="font-size: 0.8rem;">Maksimal 7 Hari Kalender</small>
                <div class="small text-muted mt-1" style="font-size: 0.75rem;">Sejak tanggal transaksi.</div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="p-3 border rounded h-100 bg-light">
                <i class="bi bi-stack" style="font-size: 24px; color: var(--primary-blue, #0284c7);"></i>
                <div class="fw-bold mt-2" style="font-size: 0.95rem;">Batas Eksemplar</div>
                <small class="text-muted" style="font-size: 0.8rem;">Maksimal 3 Buku Simultan</small>
                <div class="small text-muted mt-1" style="font-size: 0.75rem;">Secara bersamaan.</div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="p-3 border rounded h-100 bg-light">
                <i class="bi bi-cash-coin" style="font-size: 24px; color: var(--danger-red, #ef4444);"></i>
                <div class="fw-bold mt-2 text-danger" style="font-size: 0.95rem;">Denda</div>
                <small class="text-muted" style="font-size: 0.8rem;">Rp1.000 / Hari</small>
                <div class="small text-muted mt-1" style="font-size: 0.75rem;">Per hari per buku.</div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="p-3 border rounded h-100 bg-light">
                <i class="bi bi-door-open" style="font-size: 24px; color: var(--success-green, #10b981);"></i>
                <div class="fw-bold mt-2 text-success" style="font-size: 0.95rem;">Pengembalian</div>
                <small class="text-muted" style="font-size: 0.8rem;">Layanan Fisik</small>
                <div class="small text-muted mt-1" style="font-size: 0.75rem;">Di meja sirkulasi perpustakaan.</div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .last-child-no-border { border-bottom: none !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
    .last-child-no-border:last-child { border-bottom: none; }
</style>