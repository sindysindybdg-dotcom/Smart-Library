@extends('layouts.petugas')

@section('title', 'Edit Data Buku')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <a href="{{ route('buku.index') }}">Data Buku</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Edit Buku</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h2>Edit Data Buku</h2>
        <p>Perbarui informasi koleksi buku di inventaris perpustakaan.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('buku.index') }}" class="btn-outline-custom">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="panel-card" style="max-width: 900px;">
    <div class="panel-header">
        <h5 class="panel-title"><i class="bi bi-pencil-square me-2" style="color: var(--primary-blue);"></i>Form Edit Buku</h5>
    </div>
    <div class="panel-body">
        <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- Judul Buku -->
                <div class="col-md-8">
                    <label for="judul" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $buku->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- ISBN / Kode Buku -->
                <div class="col-md-4">
                    <label for="isbn" class="form-label fw-semibold">ISBN / Barcode <span class="text-danger">*</span></label>
                    <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $buku->isbn ?? $buku->kode_buku ?? $buku->nomor_isbn ?? $buku->barcode ?? '') }}" required>
                    @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Pengarang / Penulis -->
                <div class="col-md-6">
                    <label for="pengarang" class="form-label fw-semibold">Pengarang / Penulis <span class="text-danger">*</span></label>
                    <input type="text" name="pengarang" id="pengarang" class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang', $buku->pengarang ?? $buku->penulis ?? '') }}" required>
                    @error('pengarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Penerbit -->
                <div class="col-md-6">
                    <label for="penerbit" class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" name="penerbit" id="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit', $buku->penerbit) }}" required>
                    @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Tahun Terbit -->
                <div class="col-md-4">
                    <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? $buku->tahun_penerbit ?? date('Y')) }}" min="1900" max="{{ date('Y') }}" required>
                    @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Kategori -->
                <div class="col-md-4">
                    <label for="kategori_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            @php
                                // Cek fallback id_kategori atau kategori_id
                                $bukuKatId = $buku->id_kategori ?? $buku->kategori_id;
                            @endphp
                            <option value="{{ $kategori->id_kategori }}" {{ old('kategori_id', $bukuKatId) == $kategori->id_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Lokasi Rak -->
                <div class="col-md-4">
                    <label for="lokasi_rak" class="form-label fw-semibold">Lokasi Rak <span class="text-danger">*</span></label>
                    <input type="text" name="lokasi_rak" id="lokasi_rak" class="form-control @error('lokasi_rak') is-invalid @enderror" value="{{ old('lokasi_rak', $buku->lokasi_rak ?? '') }}" required>
                    @error('lokasi_rak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Stok -->
                <div class="col-md-6">
                    <label for="stok" class="form-label fw-semibold">Jumlah Stok Fisik <span class="text-danger">*</span></label>
                    <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $buku->stok) }}" min="0" required>
                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Cover Buku -->
                <div class="col-md-6">
                    <label for="cover" class="form-label fw-semibold">Cover Buku <span class="text-muted">(Opsional)</span></label>
                    
                    @if($buku->cover)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover Lama" style="height: 100px; border-radius: 6px; border: 1px solid #ddd;">
                            <small class="d-block text-muted">Cover saat ini. Upload baru untuk mengganti.</small>
                        </div>
                    @endif

                    <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                    @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn-primary-custom">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('buku.index') }}" class="btn-outline-custom">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection