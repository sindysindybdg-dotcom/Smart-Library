<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('petugas.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('petugas.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori|max:100',
            'deskripsi' => 'nullable|max:255',
        ]);

        Kategori::create($validated);
        return redirect()->route('kategori.index')->with('success', '✅ Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('petugas.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $validated = $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategoris,nama_kategori,' . $id . ',id_kategori',
            'deskripsi' => 'nullable|max:255',
        ]);

        $kategori->update($validated);
        return redirect()->route('kategori.index')->with('success', '✅ Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Cek apakah masih ada buku yang pakai kategori ini
        $kolomKategori = Schema::hasColumn('bukus', 'id_kategori') ? 'id_kategori' : 'kategori_id';
        if (Buku::where($kolomKategori, $id)->count() > 0) {
            return redirect()->route('kategori.index')->with('error', '❌ Gagal hapus: Kategori masih digunakan oleh data buku.');
        }
        
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', '✅ Kategori berhasil dihapus!');
    }
}