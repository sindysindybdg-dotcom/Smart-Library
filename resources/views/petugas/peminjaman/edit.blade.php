@extends('layouts.petugas')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <a href="{{ route('peminjaman.index') }}">Peminjaman</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Edit Peminjaman</span>
</div>

<div class="page-header">
    <div class="page-title">
        <h2>Edit Data Peminjaman</h2>
        <p>Perbarui anggota, tanggal, atau status transaksi.</p>
    </div>
</div>

<form action="{{ route('peminjaman.update', $peminjaman->id_peminjaman) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="panel-card">
        <div class="panel-body">
            <div class="mb-3">
                <label for="id_anggota" class="form-label">Anggota</label>
                <select id="id_anggota" name="id_anggota" class="form-select" required>
                    @foreach($anggotas as $anggota)
                        <option value="{{ $anggota->id_anggota }}" @selected(old('id_anggota', $peminjaman->id_anggota) == $anggota->id_anggota)>
                            {{ $anggota->nama }} ({{ $anggota->nomor_induk ?? $anggota->nis }})
                        </option>
                    @endforeach
                </select>
                @error('id_anggota') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input id="tanggal_pinjam" type="date" name="tanggal_pinjam" class="form-control"
                           value="{{ old('tanggal_pinjam', $peminjaman->tgl_peminjaman->format('Y-m-d')) }}" required>
                    @error('tanggal_pinjam') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tanggal_kembali" class="form-label">Jatuh Tempo</label>
                    <input id="tanggal_kembali" type="date" name="tanggal_kembali" class="form-control"
                           value="{{ old('tanggal_kembali', $peminjaman->tgl_jatuh_tempo->format('Y-m-d')) }}" required>
                    @error('tanggal_kembali') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        @foreach(['dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan', 'terlambat' => 'Terlambat'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $peminjaman->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Buku</label>
                <ul class="mb-0">
                    @foreach($peminjaman->details as $detail)
                        <li>{{ $detail->buku?->judul ?? 'Buku tidak tersedia' }}</li>
                    @endforeach
                </ul>
            </div>

            <button type="submit" class="btn-primary-custom">Simpan Perubahan</button>
            <a href="{{ route('peminjaman.index') }}" class="btn-outline-custom">Batal</a>
        </div>
    </div>
</form>
@endsection
