<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Load relasi details dan buku di dalamnya
        $peminjaman = Peminjaman::with(['anggota', 'details.buku'])->latest()->paginate(15);

        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggotas = Anggota::where('status', 'aktif')->get();
        $bukus = Buku::where('stok', '>', 0)->get();

        return view('petugas.peminjaman.create', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggotas,id_anggota',
            'id_buku' => 'required|exists:bukus,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        DB::transaction(function () use ($validated) {
            $buku = Buku::whereKey($validated['id_buku'])->lockForUpdate()->firstOrFail();
            if ($buku->stok < 1) {
                throw ValidationException::withMessages([
                    'id_buku' => 'Stok buku tidak mencukupi untuk dipinjam.',
                ]);
            }

            $buku->decrement('stok');
            $peminjaman = Peminjaman::create([
                'id_user' => Auth::id(),
                'id_anggota' => $validated['id_anggota'],
                'tgl_peminjaman' => $validated['tanggal_pinjam'],
                'tgl_jatuh_tempo' => $validated['tanggal_kembali'],
                'status' => 'dipinjam',
            ]);

            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_buku' => $validated['id_buku'],
            ]);
        });

        return redirect()->route('dashboard.petugas')->with('success', 'Peminjaman berhasil disimpan. Stok buku telah dikurangi.');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);
        $anggotas = Anggota::where('status', 'aktif')->get();
        $bukus = Buku::get();

        return view('petugas.peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggotas,id_anggota',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
        ]);

        DB::transaction(function () use ($peminjaman, $validated) {
            $peminjaman = Peminjaman::with('details.buku')
                ->whereKey($peminjaman->getKey())
                ->lockForUpdate()
                ->firstOrFail();
            $wasReturned = $peminjaman->status === 'dikembalikan';
            $willBeReturned = $validated['status'] === 'dikembalikan';

            if ($wasReturned && ! $willBeReturned) {
                throw ValidationException::withMessages([
                    'status' => 'Peminjaman yang sudah dikembalikan tidak dapat diaktifkan kembali.',
                ]);
            }

            if (! $wasReturned && $willBeReturned) {
                foreach ($peminjaman->details as $detail) {
                    $detail->buku?->increment('stok');
                }

                $dueDate = Carbon::parse($validated['tanggal_kembali']);
                $lateDays = $dueDate->lt(today()) ? (int) $dueDate->diffInDays(today()) : 0;
                $denda = $lateDays * 1000;
                Pengembalian::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_user' => Auth::id(),
                    'tgl_pengembalian' => today(),
                    'denda' => $denda,
                    'status_pengembalian' => $denda > 0 ? 'belum_lunas' : 'lunas',
                ]);
            }

            $peminjaman->update([
                'id_anggota' => $validated['id_anggota'],
                'tgl_peminjaman' => $validated['tanggal_pinjam'],
                'tgl_jatuh_tempo' => $validated['tanggal_kembali'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::with('details.buku')->whereKey($id)->lockForUpdate()->firstOrFail();

            if (in_array($peminjaman->status, ['dipinjam', 'terlambat'], true)) {
                foreach ($peminjaman->details as $detail) {
                    $detail->buku?->increment('stok');
                }
            }

            $peminjaman->delete();
        });

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function pengembalian(Request $request)
    {
        $barcode = $request->get('barcode');
        $peminjaman = null;

        if ($barcode) {
            // Cari berdasarkan detail buku
            $peminjaman = Peminjaman::with(['anggota', 'details.buku'])
                ->whereHas('details.buku', function ($q) use ($barcode) {
                    $q->where('isbn', 'like', "%{$barcode}%")
                        ->orWhere('judul', 'like', "%{$barcode}%");
                })
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->first();
        }

        return view('petugas.peminjaman.pengembalian', compact('peminjaman', 'barcode'));
    }

    public function prosesPengembalian(Request $request)
    {
        $validated = $request->validate([
            'id_peminjaman' => 'required|exists:peminjamen,id_peminjaman',
        ]);

        DB::transaction(function () use ($validated) {
            $peminjaman = Peminjaman::with('details.buku')
                ->whereKey($validated['id_peminjaman'])
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($peminjaman->status, ['dipinjam', 'terlambat'], true)) {
                throw ValidationException::withMessages([
                    'id_peminjaman' => 'Peminjaman ini sudah diproses atau tidak sedang dipinjam.',
                ]);
            }

            $peminjaman->update(['status' => 'dikembalikan']);
            foreach ($peminjaman->details as $detail) {
                $detail->buku?->increment('stok');
            }

            $lateDays = $peminjaman->tgl_jatuh_tempo->lt(today())
                ? (int) $peminjaman->tgl_jatuh_tempo->diffInDays(today())
                : 0;
            $denda = $lateDays * 1000;

            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_user' => Auth::id(),
                'tgl_pengembalian' => today(),
                'denda' => $denda,
                'status_pengembalian' => $denda > 0 ? 'belum_lunas' : 'lunas',
            ]);
        });

        return redirect()->route('dashboard.petugas')->with('success', 'Pengembalian berhasil diproses. Stok buku telah dikembalikan.');
    }
}
