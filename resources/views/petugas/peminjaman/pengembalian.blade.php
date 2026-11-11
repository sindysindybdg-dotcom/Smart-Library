@extends('layouts.petugas')

@section('title', 'Pengembalian Buku')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Pengembalian Buku</span>
</div>

<div class="page-header">
    <div class="page-title">
        <h2>Pengembalian Buku Cepat</h2>
        <p>Scan barcode buku atau masukkan nomor peminjaman untuk memproses pengembalian.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="panel-card">
            <div class="panel-header">
                <h5 class="panel-title"><i class="bi bi-upc-scan me-2"></i>Scan Barcode Buku</h5>
            </div>
            <div class="panel-body">
                <form action="{{ route('pengembalian.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Barcode / ISBN Buku</label>
                        <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" 
                               value="{{ old('barcode', $barcode ?? '') }}" 
                               placeholder="Contoh: 978-602-xxx atau BC-00123" autofocus required>
                        @error('barcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn-primary-custom w-100">
                        <i class="bi bi-search"></i> Cari Peminjaman
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        @if(isset($peminjaman) && $peminjaman)
        <div class="panel-card" style="border-left: 4px solid var(--primary-blue);">
            <div class="panel-header">
                <h5 class="panel-title">Data Peminjaman Ditemukan</h5>
            </div>
            <div class="panel-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Peminjam</label>
                    <div class="fw-bold">{{ $peminjaman->anggota->nama }}</div>
                    <small class="text-muted">{{ $peminjaman->anggota->kelas }} • {{ $peminjaman->anggota->nomor_induk }}</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Buku yang Dipinjam</label>
                    @foreach($peminjaman->details as $detail)
                    <div class="p-2 mb-2" style="background: #f8fafc; border-radius: 6px;">
                        <strong>{{ $detail->buku->judul ?? 'Buku Dihapus' }}</strong>
                        <div class="text-muted small">{{ $detail->buku->isbn ?? '-' }}</div>
                    </div>
                    @endforeach
                </div>
                
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted">Tanggal Pinjam</label>
                        <div>{{ \Carbon\Carbon::parse($peminjaman->tgl_peminjaman)->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted">Jatuh Tempo</label>
                        <div>{{ \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d/m/Y') }}</div>
                    </div>
                </div>
                
                @if(\Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->isPast())
                <div class="alert alert-danger mb-3">
                    <i class="bi bi-exclamation-triangle"></i> 
                    <strong>Terlambat {{ now()->diffInDays(\Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)) }} hari</strong>
                    <br>Denda: Rp{{ number_format(now()->diffInDays(\Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)) * 1000, 0, ',', '.') }}
                </div>
                @endif
                
                <form action="{{ route('pengembalian.proses') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id_peminjaman }}">
                    <button type="submit" class="btn-primary-custom w-100" onclick="return confirm('Proses pengembalian buku ini?')">
                        <i class="bi bi-check-circle"></i> Konfirmasi Pengembalian
                    </button>
                </form>
            </div>
        </div>
        @elseif(isset($barcode))
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-circle"></i> 
            <strong>Tidak Ditemukan</strong><br>
            Tidak ada peminjaman aktif untuk barcode "{{ $barcode }}".
        </div>
        @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> 
            Silakan scan barcode atau masukkan nomor untuk mencari peminjaman.
        </div>
        @endif
    </div>
</div>
@endsection