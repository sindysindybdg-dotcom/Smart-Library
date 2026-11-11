@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard') }}">Admin Perpustakaan</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <a href="{{ route('users.index') }}">Kelola Pengguna</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Tambah Pengguna</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h2>Tambah Pengguna Baru</h2>
        <p>Isi formulir di bawah ini untuk mendaftarkan akun pengguna baru ke dalam sistem.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('users.index') }}" class="btn-outline-custom">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="panel-card" style="max-width: 800px;">
    <div class="panel-header">
        <h5 class="panel-title"><i class="bi bi-person-plus me-2" style="color: var(--primary-blue);"></i>Detail Akun Pengguna</h5>
    </div>
    <div class="panel-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Username -->
                <div class="col-md-6">
                    <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Contoh: budi.santoso" required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Peran (Role) -->
                <div class="col-md-6">
                    <label for="id_role" class="form-label fw-semibold">Peran (Role) <span class="text-danger">*</span></label>
                    <select name="id_role" id="id_role" class="form-select @error('id_role') is-invalid @enderror" required>
                        <option value="">-- Pilih Peran --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}" {{ old('id_role') == $role->id_role ? 'selected' : '' }}>
                                {{ ucfirst($role->nama_role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status Akun <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn-primary-custom">
                    <i class="bi bi-save"></i> Simpan Pengguna
                </button>
                <a href="{{ route('users.index') }}" class="btn-outline-custom">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection