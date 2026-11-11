@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('content')
<!-- Hero Banner -->
<div class="hero-banner">
    <div class="hero-meta">
        <i class="bi bi-geo-alt-fill"></i> Meja Sirkulasi Utama • Shift 07:30 - 15:30 WIB • Akademik 2024/2025
    </div>
    <div class="hero-title">Selamat Pagi, Petugas {{ explode(' ', Auth::user()->nama)[0] }} {{ explode(' ', Auth::user()->nama)[1] ?? '' }}</div>
    <div class="hero-subtitle">Operasional sirkulasi perpustakaan SMK Budi Bakti Ciwidey berjalan normal. Pastikan setiap pengembalian dipindai dan diverifikasi fisiknya.</div>
    <div class="hero-actions">
        <button class="btn btn-light btn-sm" id="btnScanKembali"><i class="bi bi-upc-scan"></i> Scan Pengembalian</button>
        <button class="btn btn-light btn-sm" id="btnCari"><i class="bi bi-search"></i> Cari Buku / Anggota</button>
        <a href="{{ route('peminjaman.create') }}" class="btn-warning-custom btn-sm">
            <i class="bi bi-plus-circle"></i> Peminjaman Baru
        </a>
    </div>
</div>

<!-- Stat Cards (DINAMIS) -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Total Koleksi Fisik</div>
                <div class="stat-icon" style="background: #dbeafe; color: #2563eb;"><i class="bi bi-journal-bookmark"></i></div>
            </div>
            <div class="stat-value">{{ number_format($totalBuku) }}</div>
            <div class="stat-sub">{{ number_format((int)$totalEksemplar) }} total eksemplar</div>
            <div class="stat-footer">
                <span style="color: #10b981; font-weight: 600;"><i class="bi bi-arrow-up"></i> +{{ $bukuMasukBulanIni }} judul masuk bulan ini</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Anggota Aktif</div>
                <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;"><i class="bi bi-people"></i></div>
            </div>
            <div class="stat-value">{{ number_format($totalAnggota) }}</div>
            <div class="stat-sub">Siswa & Guru Terdaftar</div>
            <div class="stat-footer">
                <span class="text-muted">Sinkron Dapodik</span>
                <span class="badge-custom badge-success">98% Valid</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Sedang Dipinjam</div>
                <div class="stat-icon" style="background: #fef3c7; color: #d97706;"><i class="bi bi-book"></i></div>
            </div>
            <div class="stat-value">{{ number_format($peminjamanAktif) }}</div>
            <div class="stat-sub">Eksemplar aktif beredar</div>
            @php
                $totalEksemplarInt = (int)$totalEksemplar;
                $quota = $totalEksemplarInt > 0 ? min(($peminjamanAktif / $totalEksemplarInt) * 100, 100) : 0;
            @endphp
            <div class="progress mt-2" style="height: 6px;">
                <div class="progress-bar" style="width: {{ $quota }}%; background: var(--primary-blue);"></div>
            </div>
            <div class="stat-footer mt-1">
                <span class="text-muted">{{ number_format($quota, 1) }}% Quota</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="border-left: 4px solid #ef4444;">
            <div class="stat-header">
                <div class="stat-label" style="color: #ef4444;">Keterlambatan</div>
                <div class="stat-icon" style="background: #fee2e2; color: #ef4444;"><i class="bi bi-alarm"></i></div>
            </div>
            <div class="stat-value" style="color: #ef4444;">{{ $keterlambatan }} Buku</div>
            <div class="stat-sub">Rp{{ number_format((float)$totalDenda, 0, ',', '.') }} denda berjalan</div>
            <div class="stat-footer">
                <span style="color: #ef4444; font-weight: 600;"><i class="bi bi-exclamation-triangle"></i> Perlu Ditagih</span>
                <a href="{{ route('peminjaman.index') }}" style="font-size: 11px; text-decoration: none; color: inherit;">Periksa List</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Chart Aktivitas (DINAMIS & DIPERBAIKI) -->
        <div class="panel-card">
            <div class="panel-header">
                <div>
                    <h5 class="panel-title">Aktivitas Sirkulasi 7 Hari Terakhir</h5>
                    <small class="text-muted">Perbandingan volume buku dipinjam vs dikembalikan per hari</small>
                </div>
                <div class="d-flex gap-2" style="font-size: 12px;">
                    <span><span style="display:inline-block;width:10px;height:10px;background:var(--primary-blue);border-radius:2px;margin-right:4px;"></span> Peminjaman</span>
                    <span><span style="display:inline-block;width:10px;height:10px;background:#10b981;border-radius:2px;margin-right:4px;"></span> Pengembalian</span>
                </div>
            </div>
            <div class="panel-body">
                <div class="d-flex align-items-end justify-content-between" style="height: 220px; padding: 0 10px;">
                    @php
                        $allValues = array_merge(array_column($chartData, 'pinjam'), array_column($chartData, 'kembali'));
                        $maxHeight = max($allValues) ?: 1;
                    @endphp
                    @foreach($chartData as $data)
                    <div class="d-flex flex-column align-items-center" style="flex:1;">
                        <div class="d-flex gap-1 align-items-end" style="height: 180px;">
                            @php
                                $pinjamHeight = ($data['pinjam'] / $maxHeight) * 100;
                                $kembaliHeight = ($data['kembali'] / $maxHeight) * 100;
                            @endphp
                            <div style="width: 16px; background: var(--primary-blue); border-radius: 3px 3px 0 0; height: {{ $pinjamHeight }}%;"></div>
                            <div style="width: 16px; background: #10b981; border-radius: 3px 3px 0 0; height: {{ $kembaliHeight }}%;"></div>
                        </div>
                        <div style="font-size: 11px; color: var(--text-secondary); margin-top: 8px; font-weight: 600;">{{ $data['day'] }}</div>
                        <div style="font-size: 10px; color: var(--text-secondary);">{{ $data['pinjam'] }} / {{ $data['kembali'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Transaksi Hari Ini (DINAMIS) -->
        <div class="panel-card">
            <div class="panel-header">
                <div>
                    <h5 class="panel-title">
                        <span style="display:inline-block;width:10px;height:10px;background:#10b981;border-radius:50%;margin-right:8px;"></span>
                        Transaksi Sirkulasi Hari Ini
                        <span class="badge-custom badge-info ms-2">{{ $transaksiHariIni->count() }} Transaksi</span>
                    </h5>
                </div>
                <a href="{{ route('peminjaman.index') }}" class="btn-outline-custom btn-sm" style="padding: 6px 12px; font-size: 12px; text-decoration: none;">Semua Transaksi <i class="bi bi-funnel"></i></a>
            </div>
            <div class="panel-body" style="padding: 0; overflow-x: auto;">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>NO TRX / WAKTU</th>
                            <th>PEMINJAM</th>
                            <th>BUKU & BARCODE</th>
                            <th>JATUH TEMPO</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiHariIni as $trx)
                        <tr>
                            <td>
                                <strong style="color: var(--primary-blue);">TRX-{{ str_pad($trx->id_peminjaman ?? $trx->id ?? 0, 6, '0', STR_PAD_LEFT) }}</strong>
                                <div style="font-size: 11px; color: var(--text-secondary);">{{ \Carbon\Carbon::parse($trx->created_at)->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                <div class="user-details">
                                    <strong>{{ $trx->anggota->nama ?? 'N/A' }}</strong>
                                    <small>{{ $trx->anggota->kelas ?? '-' }} • NIS {{ $trx->anggota->nomor_induk ?? '-' }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ Str::limit($trx->buku?->judul ?? $trx->details->first()?->buku?->judul ?? 'N/A', 30) }}</strong>
                                    <div style="font-size: 11px; color: var(--text-secondary);">BC-{{ $trx->id_buku ?? ($trx->details->first()?->id_buku ?? '-') }}</div>
                                </div>
                            </td>
                            <td>
                                @if(isset($trx->tgl_jatuh_tempo) || isset($trx->tanggal_kembali))
                                    @php $tglKembali = $trx->tgl_jatuh_tempo ?? $trx->tanggal_kembali; @endphp
                                    <div>{{ \Carbon\Carbon::parse($tglKembali)->format('d M Y') }}</div>
                                    @if($trx->status == 'dipinjam' && \Carbon\Carbon::parse($tglKembali)->isPast())
                                        <small style="color: #ef4444;">Terlambat {{ now()->diffInDays(\Carbon\Carbon::parse($tglKembali)) }} Hari</small>
                                    @else
                                        <small style="color: var(--text-secondary);">Sisa {{ max(0, now()->diffInDays(\Carbon\Carbon::parse($tglKembali), false)) }} Hari</small>
                                    @endif
                                @else
                                    <div>-</div>
                                @endif
                            </td>
                            <td>
                                @if($trx->status == 'dipinjam')
                                    @if(isset($tglKembali) && \Carbon\Carbon::parse($tglKembali)->isPast())
                                        <span class="status-badge status-danger">Denda Rp{{ number_format(now()->diffInDays(\Carbon\Carbon::parse($tglKembali)) * 1000, 0, ',', '.') }}</span>
                                    @else
                                        <span class="status-badge status-active">Dipinjam</span>
                                    @endif
                                @else
                                    <span class="status-badge status-active">Kembali</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada transaksi hari ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Buku Populer (DINAMIS & AMAN) -->
        <div class="panel-card">
            <div class="panel-header">
                <div>
                    <h5 class="panel-title">Paling Sering Dipinjam Minggu Ini</h5>
                    <small class="text-muted">Judul dengan perputaran sirkulasi tertinggi di perpustakaan SMK</small>
                </div>
                <a href="{{ route('buku.index') }}" style="font-size: 12px; color: var(--primary-blue); text-decoration: none;">Lihat Katalog Populer</a>
            </div>
            <div class="panel-body">
                <div class="row g-3">
                    @forelse($bukuPopuler as $item)
                    <div class="col-md-4">
                        <div class="book-card">
                            <div class="book-cover" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                                @if(isset($item->buku->cover) && $item->buku->cover)
                                    <img src="{{ asset('storage/' . $item->buku->cover) }}" style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                                @else
                                    <i class="bi bi-book" style="font-size: 40px; color: var(--primary-blue);"></i>
                                @endif
                            </div>
                            <div class="book-title">{{ Str::limit($item->buku->judul ?? 'Buku Tanpa Judul', 30) }}</div>
                            <div class="book-author">{{ $item->buku->penulis ?? $item->buku->pengarang ?? 'Penulis Tidak Diketahui' }}</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge-custom badge-info">Sisa {{ $item->buku->stok ?? 0 }} Buku</span>
                                <span class="book-stat">{{ $item->total_pinjam }}x Dipinjam</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-3">
                        Belum ada data peminjaman minggu ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Scanner -->
        <div class="panel-card">
            <div class="panel-header">
                <h5 class="panel-title">
                    <i class="bi bi-upc-scan me-2" style="color: var(--primary-blue);"></i>
                    Simulator Scan Barcode
                </h5>
            </div>
            <div class="panel-body">
                <small class="text-muted d-block mb-3">Arahkan barcode scanner fisik atau ketik kode inventaris eksemplar buku di bawah untuk memproses instan.</small>
                <div class="scanner-box">
                    <i class="bi bi-upc" style="font-size: 32px; color: var(--text-secondary);"></i>
                    <div style="font-size: 11px; color: var(--text-secondary); margin: 8px 0;">Contoh: BC-00492-RPL</div>
                    <input type="text" class="form-control" id="scanInput" placeholder="Scan barcode di sini...">
                    <button class="btn-primary-custom w-100 mt-2" id="btnProsesScan" style="justify-content: center;">
                        <i class="bi bi-lightning"></i> Proses Cepat
                    </button>
                    <button class="btn-outline-custom w-100 mt-2" style="justify-content: center; font-size: 12px;">Uji Coba</button>
                </div>
            </div>
        </div>

        <!-- Perlu Pengingat (DINAMIS) -->
        <div class="panel-card">
            <div class="panel-header">
                <h5 class="panel-title">
                    <i class="bi bi-exclamation-triangle me-2" style="color: #ef4444;"></i>
                    Perlu Pengingat
                    <span class="badge-custom badge-danger ms-2">{{ $perluPengingat->count() }} Urgent</span>
                </h5>
            </div>
            <div class="panel-body" style="padding: 16px;">
                <small class="text-muted d-block mb-3">Daftar siswa melewati batas waktu kembali. Kirim notifikasi pengingat ramah via gateway WhatsApp resmi sekolah.</small>

                @forelse($perluPengingat as $item)
                <div class="reminder-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="reminder-name">{{ $item->anggota?->nama ?? 'N/A' }}</div>
                            <div class="reminder-info">{{ $item->anggota?->kelas ?? '-' }} • Terlambat {{ now()->diffInDays(\Carbon\Carbon::parse($item->tgl_jatuh_tempo ?? $item->tanggal_kembali)) }} Hari</div>
                            <div class="reminder-info mt-1">Buku: <em>{{ Str::limit($item->buku?->judul ?? $item->details->first()?->buku?->judul ?? 'N/A', 30) }}</em></div>
                            <div class="reminder-info">No. Wali: {{ $item->anggota?->no_hp ?? $item->anggota?->whatsapp ?? '-' }}</div>
                        </div>
                        <div class="text-end">
                            <div class="reminder-denda">Denda Rp{{ number_format(now()->diffInDays(\Carbon\Carbon::parse($item->tgl_jatuh_tempo ?? $item->tanggal_kembali)) * 1000, 0, ',', '.') }}</div>
                            <button class="btn-wa mt-2 btn-kirim-wa" data-nama="{{ $item->anggota?->nama ?? 'Anggota' }}" data-buku="{{ $item->buku?->judul ?? $item->details->first()?->buku?->judul ?? 'Buku' }}" data-denda="Rp{{ number_format(now()->diffInDays(\Carbon\Carbon::parse($item->tgl_jatuh_tempo ?? $item->tanggal_kembali)) * 1000, 0, ',', '.') }}">
                                <i class="bi bi-whatsapp"></i> Kirim WA
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3">
                    <i class="bi bi-check-circle"></i> Tidak ada keterlambatan
                </div>
                @endforelse

                <button class="btn-outline-custom w-100 mt-2" id="btnSerentak" style="justify-content: center; font-size: 12px;">
                    Kirim Notifikasi Serentak ({{ $perluPengingat->count() }} Siswa)
                </button>
            </div>
        </div>

        <!-- Agenda -->
        <div class="panel-card">
            <div class="panel-header">
                <h5 class="panel-title">
                    <i class="bi bi-megaphone me-2" style="color: var(--primary-blue);"></i>
                    Agenda & Pengumuman
                </h5>
            </div>
            <div class="panel-body">
                <div class="agenda-item">
                    <div class="agenda-icon" style="background: #dbeafe; color: var(--primary-blue);">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="agenda-content">
                        <div class="agenda-title">Stock Opname Koleksi Buku Baru</div>
                        <div class="agenda-desc">Jumat, 15:30 WIB - Seluruh rak referensi dan jurusan RPL.</div>
                    </div>
                </div>
                <div class="agenda-item">
                    <div class="agenda-icon" style="background: #fef3c7; color: #d97706;">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div class="agenda-content">
                        <div class="agenda-title">Integrasi Kartu Pelajar RFID</div>
                        <div class="agenda-desc">Mulai Senin depan siswa kelas X dapat tapping kartu pada kiosk.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Server Status -->
        <div class="panel-card">
            <div class="panel-body" style="padding: 16px;">
                <div class="d-flex justify-content-between align-items-center" style="font-size: 12px;">
                    <span class="text-muted">Koneksi Server SIPERPU:</span>
                    <span class="badge-custom badge-success"><i class="bi bi-wifi"></i> Tersambung (12ms)</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 1. Tombol Scan Pengembalian
document.getElementById('btnScanKembali')?.addEventListener('click', function() {
    const barcode = prompt('📦 Scan Barcode Buku yang Dikembalikan:\n\nContoh: BC-00492-RPL');
    if (barcode) window.location.href = `/pengembalian?barcode=${encodeURIComponent(barcode)}`;
});

// 2. Tombol Cari Buku / Anggota
document.getElementById('btnCari')?.addEventListener('click', function() {
    const pilihan = confirm('Pilih OK untuk mencari BUKU\nPilih Cancel untuk mencari ANGGOTA');
    if (pilihan) {
        const keyword = prompt('📚 Masukkan Judul/ISBN Buku:');
        if (keyword) window.location.href = `/buku?search=${encodeURIComponent(keyword)}`;
    } else {
        const keyword = prompt('👤 Masukkan NIS/Nama Anggota:');
        if (keyword) window.location.href = `/anggota?search=${encodeURIComponent(keyword)}`;
    }
});

// 3. Simulator Scan Barcode
const scanInput = document.getElementById('scanInput');
const btnProses = document.getElementById('btnProsesScan');

if (scanInput && btnProses) {
    scanInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') prosesScan(this.value);
    });
    btnProses.addEventListener('click', function() {
        if (scanInput.value) prosesScan(scanInput.value);
    });
}

function prosesScan(barcode) {
    const originalText = btnProses.innerHTML;
    btnProses.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
    btnProses.disabled = true;
    
    setTimeout(() => {
        alert(`📖 Hasil Scan: ${barcode}\n\nSistem akan mencari data buku...\n(Catatan: Fitur ini perlu halaman transaksi terpisah)`);
        btnProses.innerHTML = originalText;
        btnProses.disabled = false;
        scanInput.value = '';
    }, 1000);
}

// 4. Tombol Kirim WA di Panel Pengingat
document.querySelectorAll('.btn-kirim-wa').forEach(btn => {
    btn.addEventListener('click', function() {
        const nama = this.getAttribute('data-nama');
        const buku = this.getAttribute('data-buku');
        const denda = this.getAttribute('data-denda');
        
        const pesan = `Yth. Orang Tua/Wali dari ${nama},\n\nKami informasikan bahwa buku "${buku}" telah melewati batas waktu pengembalian dengan denda ${denda}.\n\nMohon segera dikembalikan ke perpustakaan.\n\nTerima kasih.\n- Perpustakaan SMK Budi Bakti`;
        window.open(`https://wa.me/?text=${encodeURIComponent(pesan)}`, '_blank');
    });
});

// 5. Tombol Kirim Notifikasi Serentak
document.getElementById('btnSerentak')?.addEventListener('click', function() {
    const count = document.querySelectorAll('.reminder-card').length;
    if (count > 0) alert(`📲 Mengirim notifikasi WhatsApp ke ${count} siswa yang terlambat...\n(Catatan: Integrasi WhatsApp Gateway diperlukan)`);
});
</script>
@endpush