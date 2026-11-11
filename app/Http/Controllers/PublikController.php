<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PublikController extends Controller
{
    public function beranda()
    {
        $bukusPopuler = DB::table('bukus')
            ->leftJoin('kategoris', 'bukus.id_kategori', '=', 'kategoris.id_kategori')
            ->select(
                'bukus.id_buku',
                'bukus.judul',
                'bukus.penulis',
                'bukus.stok',
                'bukus.status',
                'bukus.cover',
                'kategoris.nama_kategori as kategori'
            )
            ->orderByDesc('bukus.created_at')
            ->limit(4)
            ->get();

        $totalBuku = DB::table('bukus')->count();
        $totalAnggotaAktif = DB::table('anggotas')->where('status', 'aktif')->count();

        return view('publik.beranda', compact('bukusPopuler', 'totalBuku', 'totalAnggotaAktif'));
    }

    public function katalog(Request $request)
    {
        $search = $request->input('q');
        $query = DB::table('bukus')
            ->leftJoin('kategoris', 'bukus.id_kategori', '=', 'kategoris.id_kategori')
            ->select(
                'bukus.id_buku',
                'bukus.judul',
                'bukus.penulis',
                'bukus.penerbit',
                'bukus.tahun_penerbit',
                'bukus.stok',
                'bukus.status',
                'bukus.cover',
                'kategoris.nama_kategori as kategori'
            );

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('bukus.judul', 'like', "%{$search}%")
                    ->orWhere('bukus.penulis', 'like', "%{$search}%")
                    ->orWhere('bukus.isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategoris.nama_kategori', $request->input('kategori'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'tersedia') {
                $query->where('bukus.stok', '>', 0);
            } elseif ($request->input('status') === 'dipinjam') {
                $query->where('bukus.stok', '<=', 0);
            }
        }

        $bukus = $query->orderBy('bukus.judul')->limit(12)->get();

        return view('publik.katalog', compact('bukus', 'search'));
    }

    public function detail($id)
    {
        $buku = DB::table('bukus')
            ->leftJoin('kategoris', 'bukus.id_kategori', '=', 'kategoris.id_kategori')
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->where('bukus.id_buku', $id)
            ->first();

        if (! $buku) {
            throw new NotFoundHttpException('Buku tidak ditemukan.');
        }

        $rekomendasi = DB::table('bukus')
            ->leftJoin('kategoris', 'bukus.id_kategori', '=', 'kategoris.id_kategori')
            ->select(
                'bukus.id_buku',
                'bukus.judul',
                'bukus.penulis',
                'bukus.penerbit',
                'bukus.tahun_penerbit',
                'bukus.stok',
                'bukus.cover',
                'bukus.lokasi_rak',
                'kategoris.nama_kategori as kategori'
            )
            ->where('bukus.id_kategori', $buku->id_kategori)
            ->where('bukus.id_buku', '!=', $buku->id_buku)
            ->orderBy('bukus.judul')
            ->limit(4)
            ->get();

        return view('publik.detail', compact('buku', 'rekomendasi'));
    }

    public function panduan()
    {
        return view('publik.panduan');
    }
}
