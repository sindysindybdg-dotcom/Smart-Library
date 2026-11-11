@extends('layouts.petugas')

@section('title', 'Data Buku')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Data Buku (Katalog & Inventaris)</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h2>Katalog & Inventaris Buku</h2>
        <p>Kelola data koleksi buku, stok fisik, klasifikasi DDC, dan lokasi penyimpanan rak.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('buku.create') }}" class="btn-primary-custom">
            <i class="bi bi-plus-circle"></i> Tambah Buku Baru
        </a>
    </div>
</div>

<!-- Alert Sukses -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; border: 1px solid #86efac; background: #dcfce7; color: #166534;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Filter Bar -->
<div class="panel-card">
    <div class="panel-body" style="padding: 16px 20px;">
        <form action="{{ route('buku.index') }}" method="GET" id="filterForm">
            <div class="d-flex gap-3 align-items-center flex-wrap">
                <div class="search-box" style="width: 300px;">
                    <i class="bi bi-search" style="color: var(--text-secondary);"></i>
                    <input type="text" name="search" id="searchInput" placeholder="Cari judul, pengarang, atau ISBN..." value="{{ request('search') }}">
                </div>
                <select name="status_stok" class="form-select" style="width: auto; font-size: 13px;" onchange="this.form.submit()">
                    <option value="">Semua Status Stok</option>
                    <option value="tersedia" {{ request('status_stok') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ request('status_stok') == 'habis' ? 'selected' : '' }}>Stok Habis</option>
                </select>
                <button type="submit" class="btn-outline-custom" style="padding: 8px 12px;"><i class="bi bi-funnel"></i> Filter</button>
                <a href="{{ route('buku.index') }}" class="btn-outline-custom" style="padding: 8px 12px;"><i class="bi bi-arrow-clockwise"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Books Table -->
<div class="panel-card">
    <div class="panel-body" style="padding: 0; overflow-x: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width: 60px;">COVER</th>
                    <th>JUDUL & PENGARANG</th>
                    <th>ISBN</th>
                    <th>KATEGORI</th>
                    <th>LOKASI RAK</th>
                    <th>STOK</th>
                    <th>STATUS</th>
                    <th style="width: 120px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukus as $buku)
                <tr>
                    <td>
                        @if($buku->cover)
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover" style="width: 40px; height: 55px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-color);">
                        @else
                            <div style="width: 40px; height: 55px; background: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="user-details">
                            <strong style="font-size: 13px;">{{ Str::limit($buku->judul, 40) }}</strong>
                            <small>{{ $buku->pengarang ?? $buku->penulis }} • {{ $buku->tahun_terbit ?? $buku->tahun_penerbit }}</small>
                        </div>
                    </td>
                    <td>
                        <div style="font-family: monospace; font-size: 12px; font-weight: 600; color: var(--primary-blue);">
                            {{ $buku->isbn ?? $buku->kode_buku ?? '-' }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-custom badge-info">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                    </td>
                    <td>
                        <div style="font-size: 12px; font-weight: 600;">{{ $buku->lokasi_rak ?? '-' }}</div>
                    </td>
                    <td>
                        <div style="font-size: 14px; font-weight: 700;">{{ $buku->stok }} <small style="font-weight: 400; color: var(--text-secondary);">eks</small></div>
                    </td>
                    <td>
                        @if($buku->stok > 5)
                            <span class="status-badge status-active">Tersedia</span>
                        @elseif($buku->stok > 0)
                            <span class="status-badge status-warning">Menipis</span>
                        @else
                            <span class="status-badge status-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('buku.edit', $buku->id_buku ?? $buku->id) }}" class="btn btn-sm" style="background: #dbeafe; color: #2563eb;" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $buku->id_buku ?? $buku->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626;" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 48px; color: var(--text-secondary);"></i>
                        <p class="text-muted mt-2">Tidak ada data buku yang ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($bukus->hasPages())
    <div class="panel-body" style="padding: 16px 24px; border-top: 1px solid var(--border-color);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span style="font-size: 13px; color: var(--text-secondary);">
                Menampilkan <strong>{{ $bukus->firstItem() }}</strong> - <strong>{{ $bukus->lastItem() }}</strong> dari <strong>{{ $bukus->total() }}</strong> buku
            </span>
            <div class="pagination-custom">
                {{ $bukus->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
let typingTimer;
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });
}
</script>
@endpush