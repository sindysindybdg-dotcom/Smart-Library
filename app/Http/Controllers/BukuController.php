<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('id_kategori', $request->kategori_id);
        }

        if ($request->filled('status_stok')) {
            if ($request->status_stok == 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->status_stok == 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        $bukus = $query->paginate(10);
        $kategoris = Kategori::all();

        return view('petugas.buku.index', compact('bukus', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();

        return view('petugas.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|max:50|unique:bukus,isbn',
            'judul' => 'required|max:200',
            'pengarang' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:'.date('Y'),
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'lokasi_rak' => 'nullable|max:50',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $existingColumns = Schema::getColumnListing('bukus');
        $dataToSave = [];

        $dataToSave['judul'] = $validated['judul'];
        $dataToSave['penerbit'] = $validated['penerbit'];
        $dataToSave['stok'] = $validated['stok'];

        if (in_array('penulis', $existingColumns)) {
            $dataToSave['penulis'] = $validated['pengarang'];
        } elseif (in_array('pengarang', $existingColumns)) {
            $dataToSave['pengarang'] = $validated['pengarang'];
        }

        if (in_array('tahun_penerbit', $existingColumns)) {
            $dataToSave['tahun_penerbit'] = $validated['tahun_terbit'];
        } elseif (in_array('tahun_terbit', $existingColumns)) {
            $dataToSave['tahun_terbit'] = $validated['tahun_terbit'];
        }

        if (in_array('id_kategori', $existingColumns)) {
            $dataToSave['id_kategori'] = $validated['kategori_id'];
        } elseif (in_array('kategori_id', $existingColumns)) {
            $dataToSave['kategori_id'] = $validated['kategori_id'];
        }

        if (in_array('lokasi_rak', $existingColumns)) {
            $dataToSave['lokasi_rak'] = $validated['lokasi_rak'] ?? '-';
        }

        $isbnCol = null;
        foreach (['kode_buku', 'nomor_isbn', 'barcode', 'isbn'] as $col) {
            if (in_array($col, $existingColumns)) {
                $isbnCol = $col;
                break;
            }
        }

        if ($isbnCol) {
            $dataToSave[$isbnCol] = $validated['isbn'];
        }

        if (in_array('status', $existingColumns)) {
            $dataToSave['status'] = 'tersedia';
        }

        if ($request->hasFile('cover') && in_array('cover', $existingColumns)) {
            $dataToSave['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($dataToSave);

        return redirect()->route('buku.index')->with('success', '✅ Buku berhasil ditambahkan!');
    }

    // ✅ METHOD BARU: show() - untuk menangani route resource /buku/{id}
    // Redirect ke halaman detail publik agar tidak error "undefined method"
    public function show($id)
    {
        return redirect()->route('publik.detail', $id);
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();

        return view('petugas.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $validated = $request->validate([
            'isbn' => 'required|max:50|unique:bukus,isbn,'.$buku->id_buku.',id_buku',
            'judul' => 'required|max:200',
            'pengarang' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:'.date('Y'),
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'lokasi_rak' => 'nullable|max:50',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $existingColumns = Schema::getColumnListing('bukus');
        $dataToUpdate = [];

        $dataToUpdate['judul'] = $validated['judul'];
        $dataToUpdate['penerbit'] = $validated['penerbit'];
        $dataToUpdate['stok'] = $validated['stok'];

        if (in_array('penulis', $existingColumns)) {
            $dataToUpdate['penulis'] = $validated['pengarang'];
        } elseif (in_array('pengarang', $existingColumns)) {
            $dataToUpdate['pengarang'] = $validated['pengarang'];
        }

        if (in_array('tahun_penerbit', $existingColumns)) {
            $dataToUpdate['tahun_penerbit'] = $validated['tahun_terbit'];
        } elseif (in_array('tahun_terbit', $existingColumns)) {
            $dataToUpdate['tahun_terbit'] = $validated['tahun_terbit'];
        }

        if (in_array('id_kategori', $existingColumns)) {
            $dataToUpdate['id_kategori'] = $validated['kategori_id'];
        } elseif (in_array('kategori_id', $existingColumns)) {
            $dataToUpdate['kategori_id'] = $validated['kategori_id'];
        }

        if (in_array('lokasi_rak', $existingColumns)) {
            $dataToUpdate['lokasi_rak'] = $validated['lokasi_rak'] ?? '-';
        }

        $isbnCol = null;
        foreach (['kode_buku', 'nomor_isbn', 'barcode', 'isbn'] as $col) {
            if (in_array($col, $existingColumns)) {
                $isbnCol = $col;
                break;
            }
        }

        if ($isbnCol) {
            $dataToUpdate[$isbnCol] = $validated['isbn'];
        }

        if (in_array('status', $existingColumns)) {
            $dataToUpdate['status'] = 'tersedia';
        }

        if ($request->hasFile('cover') && in_array('cover', $existingColumns)) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $dataToUpdate['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($dataToUpdate);

        return redirect()->route('buku.index')->with('success', '✅ Data buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->cover && Schema::hasColumn('bukus', 'cover')) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();

        return redirect()->route('buku.index')->with('success', '✅ Buku berhasil dihapus!');
    }
}
