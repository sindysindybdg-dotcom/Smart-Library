<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalEksemplar = Buku::sum('stok');
        $totalAnggota = Anggota::where('status', 'aktif')->count();
        $peminjamanAktif = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count();
        $bukuMasukBulanIni = Buku::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $peminjamanTerlambat = Peminjaman::with(['anggota', 'buku', 'details.buku'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->whereDate('tgl_jatuh_tempo', '<', today())
            ->orderBy('tgl_jatuh_tempo')
            ->get();
        $keterlambatan = $peminjamanTerlambat->count();
        $totalDenda = $peminjamanTerlambat->sum(
            fn (Peminjaman $peminjaman) => (int) $peminjaman->tgl_jatuh_tempo->diffInDays(today()) * 1000
        );
        $perluPengingat = $peminjamanTerlambat->take(6);

        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartData[] = [
                'day' => $date->locale('id')->isoFormat('dddd'),
                'pinjam' => Peminjaman::whereDate('created_at', $date)->count(),
                'kembali' => Peminjaman::where('status', 'dikembalikan')
                    ->whereDate('updated_at', $date)
                    ->count(),
            ];
        }

        $transaksiHariIni = Peminjaman::with(['anggota', 'buku', 'details.buku'])
            ->whereDate('created_at', today())
            ->latest()
            ->limit(10)
            ->get();

        $bukuPopuler = Peminjaman::with('details.buku')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->flatMap(fn (Peminjaman $peminjaman) => $peminjaman->details->pluck('buku'))
            ->filter()
            ->countBy('id_buku')
            ->sortDesc()
            ->take(3)
            ->map(function (int $totalPinjam, int $idBuku) {
                return (object) [
                    'buku' => Buku::find($idBuku),
                    'total_pinjam' => $totalPinjam,
                ];
            })
            ->filter(fn ($item) => $item->buku)
            ->values();

        return view('petugas.dashboard', compact(
            'totalBuku',
            'totalEksemplar',
            'totalAnggota',
            'peminjamanAktif',
            'keterlambatan',
            'totalDenda',
            'bukuMasukBulanIni',
            'chartData',
            'transaksiHariIni',
            'perluPengingat',
            'bukuPopuler'
        ));
    }
}
