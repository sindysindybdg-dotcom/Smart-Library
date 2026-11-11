@extends('layouts.petugas')

@section('title', 'Daftar Keterlambatan')

@section('content')
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard.petugas') }}">Dashboard</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Daftar Keterlambatan</span>
</div>

<div class="page-header">
    <div class="page-title">
        <h2>Peminjam Terlambat</h2>
        <p>Daftar anggota yang belum mengembalikan buku melewati batas waktu.</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="panel-card">
    <div class="panel-body" style="padding: 0; overflow-x: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>PEMINJAM</th>
                    <th>BUKU</th>
                    <th>TGL PINJAM</th>
                    <th>JATUH TEMPO</th>
                    <th>TERLAMBAT</th>
                    <th>DENDA</th>
                    <th style="width: 120px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $keterlambatan = \App\Models\Peminjaman::with(['anggota', 'details.buku'])
                        ->where('status', 'dipinjam')
                        ->where('tgl_jatuh_tempo', '<', now())
                        ->orderBy('tgl_jatuh_tempo', 'asc')
                        ->get();
                @endphp
                
                @forelse($keterlambatan as $item)
                @php
                    $hariTerlambat = now()->diffInDays(\Carbon\Carbon::parse($item->tgl_jatuh_tempo));
                    $denda = $hariTerlambat * 1000;
                @endphp
                <tr>
                    <td>
                        <strong>{{ $item->anggota->nama }}</strong><br>
                        <small class="text-muted">{{ $item->anggota->kelas }} • {{ $item->anggota->nomor_induk }}</small>
                    </td>
                    <td>
                        @foreach($item->details as $detail)
                            <div>• {{ Str::limit($detail->buku->judul ?? 'Buku Dihapus', 30) }}</div>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_peminjaman)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge-custom badge-danger">{{ $hariTerlambat }} Hari</span>
                    </td>
                    <td>
                        <strong>Rp{{ number_format($denda, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <form action="{{ route('pengembalian.proses') }}" method="POST" onsubmit="return confirm('Proses pengembalian dengan denda Rp{{ number_format($denda, 0, ',', '.') }}?');">
                                @csrf
                                <input type="hidden" name="id_peminjaman" value="{{ $item->id_peminjaman }}">
                                <button type="submit" class="btn btn-sm" style="background: #dcfce7; color: #166534; border: none;" title="Kembalikan">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>
                            <button class="btn btn-sm btn-kirim-wa" 
                                    data-nama="{{ $item->anggota->nama }}" 
                                    data-buku="{{ $item->details->first()?->buku?->judul ?? 'Buku' }}"
                                    data-hari="{{ $hariTerlambat }}"
                                    data-denda="{{ $denda }}"
                                    style="background: #dbeafe; color: #2563eb; border: none;" 
                                    title="Kirim WA">
                                <i class="bi bi-whatsapp"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-check-circle" style="font-size: 48px; color: #10b981;"></i>
                        <p class="text-muted mt-2">Tidak ada peminjaman yang terlambat.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-kirim-wa').forEach(btn => {
    btn.addEventListener('click', function() {
        const nama = this.getAttribute('data-nama');
        const buku = this.getAttribute('data-buku');
        const hari = this.getAttribute('data-hari');
        const denda = this.getAttribute('data-denda');
        
        const pesan = `Yth. ${nama},\n\nKami informasikan bahwa pengembalian buku "${buku}" telah terlambat ${hari} hari dengan denda Rp${denda}.\n\nMohon segera kembalikan ke perpustakaan.\n\nTerima kasih.\n- Perpustakaan SMK Budi Bakti`;
        
        window.open(`https://wa.me/?text=${encodeURIComponent(pesan)}`, '_blank');
    });
});
</script>
@endpush