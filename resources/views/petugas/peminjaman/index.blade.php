@extends('layouts.petugas')

@section('title', 'Data Peminjaman')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Data Peminjaman</span>
</div>

<div class="page-header">
    <div class="page-title">
        <h2>Riwayat Peminjaman & Pengembalian</h2>
    </div>
    <a href="{{ route('peminjaman.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-circle"></i> Peminjaman Baru
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="panel-card">
    <div class="panel-body" style="padding: 0; overflow-x: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>PEMINJAM</th>
                    <th>BUKU</th>
                    <th>JATUH TEMPO</th>
                    <th>STATUS</th>
                    <th style="width: 100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr>
                    <td>
                        <div>{{ $item->tgl_peminjaman ? \Carbon\Carbon::parse($item->tgl_peminjaman)->format('d/m/Y') : '-' }}</div>
                        <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                    </td>
                    <td>
                        <strong>{{ $item->anggota->nama ?? 'N/A' }}</strong><br>
                        <small class="text-muted">{{ $item->anggota->kelas ?? '-' }}</small>
                    </td>
                    <td>
                        @foreach($item->details as $detail)
                            <div>• {{ Str::limit($detail->buku->judul ?? 'Buku Dihapus', 30) }}</div>
                        @endforeach
                    </td>
                    <td>
                        <div>{{ $item->tgl_jatuh_tempo ? \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') : '-' }}</div>
                        @if($item->status == 'dipinjam' && $item->tgl_jatuh_tempo && \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->isPast())
                            <small class="text-danger fw-bold">Terlambat</small>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 'dipinjam')
                            <span class="badge-custom badge-warning">Dipinjam</span>
                        @elseif($item->status == 'terlambat')
                            <span class="badge-custom badge-danger">Terlambat</span>
                        @else
                            <span class="badge-custom badge-success">Kembali</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if(in_array($item->status, ['dipinjam', 'terlambat'], true))
                            <form action="{{ route('pengembalian.proses') }}" method="POST" onsubmit="return confirm('Proses pengembalian buku ini?');">
                                @csrf
                                <input type="hidden" name="id_peminjaman" value="{{ $item->id_peminjaman }}">
                                <button type="submit" class="btn btn-sm" style="background: #dcfce7; color: #166534;" title="Kembalikan">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('peminjaman.destroy', $item->id_peminjaman) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
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
                <tr><td colspan="6" class="text-center py-4">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="panel-body" style="padding: 16px;">
        {{ $peminjaman->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection