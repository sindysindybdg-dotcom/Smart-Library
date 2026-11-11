@extends('layouts.petugas')
@section('title', 'Edit Anggota')
@section('content')
<div class="panel-card" style="max-width: 700px;">
    <div class="panel-body">
        <h4 class="mb-4">Edit Data Anggota</h4>
        <form action="{{ route('anggota.update', $anggota->id_anggota) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">NIS / NIM <span class="text-danger">*</span></label>
                    <input type="text" name="nomor_induk" class="form-control @error('nomor_induk') is-invalid @enderror" value="{{ old('nomor_induk', $anggota->nomor_induk) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $anggota->nama) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kelas / Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $anggota->kelas) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="L" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $anggota->no_hp) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="aktif" {{ old('status', $anggota->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $anggota->status) == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn-primary-custom"><i class="bi bi-save"></i> Simpan Perubahan</button>
                <a href="{{ route('anggota.index') }}" class="btn-outline-custom">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection