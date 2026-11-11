@extends('layouts.petugas')

@section('title', 'Data Anggota')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Data Anggota</span>
</div>

<div class="page-header">
    <div class="page-title">
        <h2>Daftar Anggota Perpustakaan</h2>
    </div>
    <a href="{{ route('anggota.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-circle"></i> Tambah Anggota
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="panel-card">
    <div class="panel-body" style="padding: 0; overflow-x: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NIS / NIM</th>
                    <th>NAMA LENGKAP</th>
                    <th>KELAS</th>
                    <th>STATUS</th>
                    <th style="width: 120px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggotas as $index => $anggota)
                <tr>
                    <td>{{ $anggotas->firstItem() + $index }}</td>
                    <td><strong>{{ $anggota->nomor_induk }}</strong></td>
                    <td>{{ $anggota->nama }}</td>
                    <td>{{ $anggota->kelas }}</td>
                    <td>
                        @if($anggota->status == 'aktif')
                            <span class="badge-custom badge-success">Aktif</span>
                        @else
                            <span class="badge-custom badge-danger">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('anggota.edit', $anggota->id_anggota) }}" class="btn btn-sm" style="background: #dbeafe; color: #2563eb;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('anggota.destroy', $anggota->id_anggota) }}" method="POST" onsubmit="return confirm('Yakin hapus anggota ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4">Belum ada data anggota.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="panel-body" style="padding: 16px;">
        {{ $anggotas->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection