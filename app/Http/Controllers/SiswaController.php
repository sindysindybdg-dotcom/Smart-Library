<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    // 1. Katalog Buku (Dashboard Siswa)
    public function katalog(Request $request)
    {
        $search = $request->input('q');
        $kategoriId = $request->input('kategori');
        $sort = $request->input('sort', 'terbaru');

        $query = Buku::with('kategori');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($kategoriId) {
            $query->where('id_kategori', $kategoriId);
        }

        switch ($sort) {
            case 'terpopuler':
                $query->orderBy('stok', 'desc');
                break;
            case 'az':
                $query->orderBy('judul', 'asc');
                break;
            default:
                $query->latest();
        }

        $bukus = $query->paginate(12);
        $kategoris = Kategori::all();

        return view('siswa.katalog', compact('bukus', 'kategoris', 'search'));
    }

    // 2. Riwayat Peminjaman
    public function riwayat()
    {
        $user = Auth::user();
        $anggotaId = Anggota::where('user_id', $user->id_user)->value('id_anggota');
        $stats = ['dipinjam' => 0, 'dikembalikan' => 0, 'terlambat' => 0, 'total_denda' => 0];
        $riwayat = collect();

        if ($anggotaId) {
            $loans = Peminjaman::with(['details.buku', 'pengembalian'])
                ->where('id_anggota', $anggotaId)
                ->latest('tgl_peminjaman')
                ->limit(20)
                ->get();

            $riwayat = $loans->flatMap(function (Peminjaman $loan) {
                $lateDays = $loan->tgl_jatuh_tempo->lt(today())
                    ? (int) $loan->tgl_jatuh_tempo->diffInDays(today())
                    : 0;
                $denda = $loan->pengembalian?->denda ?? (
                    in_array($loan->status, ['dipinjam', 'terlambat'], true) ? $lateDays * 1000 : 0
                );

                return $loan->details->map(function ($detail) use ($loan, $denda) {
                    return (object) [
                        'id_peminjaman' => $loan->id_peminjaman,
                        'id_buku' => $detail->id_buku,
                        'judul' => $detail->buku?->judul,
                        'penulis' => $detail->buku?->penulis,
                        'cover' => $detail->buku?->cover,
                        'status' => $loan->status,
                        'tanggal_pinjam' => $loan->tgl_peminjaman,
                        'tanggal_kembali' => $loan->tgl_jatuh_tempo,
                        'tanggal_pengembalian' => $loan->pengembalian?->tgl_pengembalian,
                        'denda' => $denda,
                    ];
                });
            });

            $allLoans = Peminjaman::with('pengembalian')
                ->where('id_anggota', $anggotaId)
                ->get();
            $stats['dipinjam'] = $allLoans
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->sum(fn (Peminjaman $loan) => $loan->details()->count());
            $stats['dikembalikan'] = $allLoans
                ->where('status', 'dikembalikan')
                ->sum(fn (Peminjaman $loan) => $loan->details()->count());
            foreach ($allLoans as $loan) {
                $lateDays = $loan->tgl_jatuh_tempo->lt(today())
                    ? (int) $loan->tgl_jatuh_tempo->diffInDays(today())
                    : 0;
                $fine = $loan->pengembalian?->denda ?? (
                    in_array($loan->status, ['dipinjam', 'terlambat'], true) ? $lateDays * 1000 : 0
                );
                $stats['total_denda'] += $fine;
                if ($fine > 0) {
                    $stats['terlambat']++;
                }
            }
        }

        return view('siswa.riwayat', compact('riwayat', 'stats'));
    }

    // 3. Profil Siswa
    public function profil()
    {
        $user = Auth::user();
        $userId = $user->id_user;
        $anggota = Anggota::where('user_id', $userId)->first();

        $dataProfil = [
            'nama' => $user->nama ?? 'Siswa',
            'nisn' => $anggota->nomor_induk ?? '-',
            'kelas' => $anggota->kelas ?? '-',
            'program_keahlian' => 'Pengembangan Perangkat Lunak dan Gim (PPLG)',
            'jenis_kelamin' => $anggota->jenis_kelamin ?? '-',
            'tempat_lahir' => $anggota->tempat_lahir ?? '-',
            'tanggal_lahir' => isset($anggota->tanggal_lahir) ? Carbon::parse($anggota->tanggal_lahir)->format('d M Y') : '-',
            'alamat' => $anggota->alamat ?? '-',
            'whatsapp' => $anggota->whatsapp ?? $anggota->no_telepon ?? '-',
            'email' => $anggota->email ?? '-',
            'tanggal_registrasi' => isset($user->created_at) ? Carbon::parse($user->created_at)->format('d M Y') : '-',
            'no_anggota' => 'M-'.date('Y').'-'.str_pad($userId, 3, '0', STR_PAD_LEFT),
        ];

        $statsBaca = [
            'total' => 0,
            'terlambat' => 0,
            'kategori_favorit' => 'Umum',
            'aktif' => null,
        ];

        if ($anggota) {
            $loans = Peminjaman::with(['details.buku', 'pengembalian'])
                ->where('id_anggota', $anggota->id_anggota)
                ->get();

            $statsBaca['total'] = $loans->count();
            $statsBaca['terlambat'] = $loans->filter(function (Peminjaman $loan) {
                return (float) ($loan->pengembalian?->denda ?? 0) > 0
                    || (in_array($loan->status, ['dipinjam', 'terlambat'], true)
                        && $loan->tgl_jatuh_tempo->lt(today()));
            })->count();

            $activeLoan = $loans->firstWhere('status', 'dipinjam');
            $activeBook = $activeLoan?->details->first()?->buku;
            if ($activeLoan && $activeBook) {
                $statsBaca['aktif'] = (object) [
                    'judul' => $activeBook->judul,
                    'cover' => $activeBook->cover,
                    'tanggal_kembali' => $activeLoan->tgl_jatuh_tempo,
                ];
            }

            $favoriteCategory = DB::table('detail_peminjamen')
                ->join('bukus', 'detail_peminjamen.id_buku', '=', 'bukus.id_buku')
                ->join('kategoris', 'bukus.id_kategori', '=', 'kategoris.id_kategori')
                ->join('peminjamen', 'detail_peminjamen.id_peminjaman', '=', 'peminjamen.id_peminjaman')
                ->where('peminjamen.id_anggota', $anggota->id_anggota)
                ->select('kategoris.nama_kategori')
                ->groupBy('kategoris.id_kategori', 'kategoris.nama_kategori')
                ->orderByRaw('COUNT(*) DESC')
                ->value('kategoris.nama_kategori');
            $statsBaca['kategori_favorit'] = $favoriteCategory ?? 'Umum';
        }

        return view('siswa.profil', compact('dataProfil', 'user', 'statsBaca'));
    }
}
