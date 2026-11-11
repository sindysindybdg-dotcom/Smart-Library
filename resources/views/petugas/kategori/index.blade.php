@extends('layouts.petugas')

@section('title', 'Master Data Kategori')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Master Data Kategori</span>
</div>

<div class="page-header">
    <div class="page-title">
        <h2>Kategori Buku</h2>
    </div>
    <a href="{{ route('kategori.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
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
                    <th>NAMA KATEGORI</th>
                    <th>DESKRIPSI</th>
                    <th style="width: 120px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $index => $kategori)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $kategori->nama_kategori }}</strong></td>
                    <td>{{ $kategori->deskripsi ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <!-- TOMBOL EDIT -->
                            <a href="{{ route('kategori.edit', $kategori->id_kategori) }}" class="btn btn-sm" style="background: #dbeafe; color: #2563eb;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <!-- TOMBOL HAPUS (WAJIB PAKAI FORM + @method('DELETE')) -->
                            <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?');">
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
                <tr><td colspan="4" class="text-center py-4">Belum ada data kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection