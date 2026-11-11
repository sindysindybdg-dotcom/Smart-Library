@extends('layouts.petugas')

@section('title', 'Tambah Buku Baru')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <a href="{{ route('buku.index') }}">Data Buku</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Tambah Buku Baru</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h2>Tambah Data Buku Baru</h2>
        <p>Masukkan informasi lengkap mengenai koleksi buku yang akan ditambahkan ke inventaris perpustakaan.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('buku.index') }}" class="btn-outline-custom">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="panel-card" style="max-width: 900px;">
    <div class="panel-header">
        <h5 class="panel-title"><i class="bi bi-book-half me-2" style="color: var(--primary-blue);"></i>Detail Informasi Buku</h5>
    </div>
    <div class="panel-body">
        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <!-- Judul Buku -->
                <div class="col-md-8">
                    <label for="judul" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Masukkan judul lengkap buku" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- ISBN -->
                <div class="col-md-4">
                    <label for="isbn" class="form-label fw-semibold">ISBN / Barcode <span class="text-danger">*</span></label>
                    <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn') }}" placeholder="Contoh: 978-602-xxx" required>
                    @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Pengarang -->
                <div class="col-md-6">
                    <label for="pengarang" class="form-label fw-semibold">Pengarang / Penulis <span class="text-danger">*</span></label>
                    <input type="text" name="pengarang" id="pengarang" class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang') }}" placeholder="Nama penulis buku" required>
                    @error('pengarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Penerbit -->
                <div class="col-md-6">
                    <label for="penerbit" class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" name="penerbit" id="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') }}" placeholder="Nama penerbit" required>
                    @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Tahun Terbit -->
                <div class="col-md-4">
                    <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}" required>
                    @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Kategori -->
                <div class="col-md-4">
                    <label for="kategori_id" class="form-label fw-semibold">Kategori / Klasifikasi <span class="text-danger">*</span></label>
                    <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}" {{ old('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Lokasi Rak -->
                <div class="col-md-4">
                    <label for="lokasi_rak" class="form-label fw-semibold">Lokasi Rak <span class="text-danger">*</span></label>
                    <input type="text" name="lokasi_rak" id="lokasi_rak" class="form-control @error('lokasi_rak') is-invalid @enderror" value="{{ old('lokasi_rak') }}" placeholder="Contoh: Rak A-01" required>
                    @error('lokasi_rak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Stok -->
                <div class="col-md-6">
                    <label for="stok" class="form-label fw-semibold">Jumlah Stok Fisik <span class="text-danger">*</span></label>
                    <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 1) }}" min="0" required>
                    <small class="text-muted">Jumlah eksemplar fisik buku yang tersedia di perpustakaan.</small>
                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Cover Buku -->
                <div class="col-md-6">
                    <label for="cover" class="form-label fw-semibold">Cover Buku <span class="text-muted">(Opsional)</span></label>
                    <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                    <small class="text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
                    @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn-primary-custom">
                    <i class="bi bi-save"></i> Simpan Data Buku
                </button>
                <a href="{{ route('buku.index') }}" class="btn-outline-custom">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection