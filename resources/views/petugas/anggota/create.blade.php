@extends('layouts.petugas')
@section('title', 'Tambah Anggota')
@section('content')
<div class="panel-card" style="max-width: 700px;">
    <div class="panel-body">
        <h4 class="mb-4">Tambah Anggota Baru</h4>
        <form action="{{ route('anggota.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">NIS / NIM <span class="text-danger">*</span></label>
                    <input type="text" name="nomor_induk" class="form-control @error('nomor_induk') is-invalid @enderror" value="{{ old('nomor_induk') }}" required>
                    @error('nomor_induk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kelas / Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas') }}" placeholder="Contoh: XII RPL 1" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn-primary-custom"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('anggota.index') }}" class="btn-outline-custom">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection