@extends('layouts.petugas')

@section('title', 'Edit Kategori')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <a href="{{ route('kategori.index') }}">Kategori</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Edit Kategori</span>
</div>

<div class="panel-card" style="max-width: 600px;">
    <div class="panel-body">
        <!-- PENTING: action mengarah ke route update dengan ID, method POST + @method('PUT') -->
        <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-primary-custom"><i class="bi bi-save"></i> Simpan Perubahan</button>
                <a href="{{ route('kategori.index') }}" class="btn-outline-custom">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection