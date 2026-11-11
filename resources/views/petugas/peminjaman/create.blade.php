@extends('layouts.petugas')

@section('title', 'Peminjaman Baru')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Peminjaman Baru</span>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="page-header">
    <div class="page-title">
        <h2>Transaksi Peminjaman Buku</h2>
        <p>Input data peminjaman baru untuk anggota perpustakaan</p>
    </div>
</div>

<form action="{{ route('peminjaman.store') }}" method="POST">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="panel-card">
                <div class="panel-header"><h5 class="panel-title">Informasi Peminjaman</h5></div>
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Anggota</label>
                        <select name="id_anggota" class="form-select" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id_anggota }}">{{ $anggota->nama }} ({{ $anggota->nomor_induk }})</option>
                            @endforeach
                        </select>
                        @error('id_anggota') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih Buku</label>
                        <select name="id_buku" class="form-select" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($bukus as $buku)
                                <option value="{{ $buku->id_buku }}">{{ $buku->judul }} (Stok: {{ $buku->stok }})</option>
                            @endforeach
                        </select>
                        @error('id_buku') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="panel-card">
                <div class="panel-body">
                    <button type="submit" class="btn-primary-custom w-100 mb-2">
                        <i class="bi bi-save"></i> Simpan Peminjaman
                    </button>
                    <a href="{{ route('dashboard.petugas') }}" class="btn-outline-custom w-100">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection