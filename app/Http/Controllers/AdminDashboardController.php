<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar yang pasti aman
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::where('status', 'aktif')->count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

        return view('admin.dashboard', compact(
            'totalBuku', 
            'totalAnggota', 
            'peminjamanAktif'
        ));
    }
}