<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::orderBy('created_at', 'desc')->paginate(10);

        return view('petugas.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        return view('petugas.anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_induk' => 'required|unique:anggotas,nomor_induk|max:20',
            'nama' => 'required|max:100',
            'kelas' => 'required|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|max:20',
            'alamat' => 'nullable|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['nis'] = $validated['nomor_induk'];
        Anggota::create($validated);

        return redirect()->route('anggota.index')->with('success', '✅ Data anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('petugas.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validate([
            'nomor_induk' => 'required|max:20|unique:anggotas,nomor_induk,'.$id.',id_anggota',
            'nama' => 'required|max:100',
            'kelas' => 'required|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|max:20',
            'alamat' => 'nullable|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['nis'] = $validated['nomor_induk'];
        $anggota->update($validated);

        return redirect()->route('anggota.index')->with('success', '✅ Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        // Cek apakah anggota masih punya peminjaman aktif
        $peminjamanAktif = Peminjaman::where('id_anggota', $id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        if ($peminjamanAktif > 0) {
            return redirect()->route('anggota.index')->with('error', '❌ Gagal hapus: Anggota masih memiliki '.$peminjamanAktif.' peminjaman aktif.');
        }

        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', '✅ Data anggota berhasil dihapus!');
    }
}
