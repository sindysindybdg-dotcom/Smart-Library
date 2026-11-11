<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_penerbit' => 2005, 'kategori' => 'Fiksi', 'stok' => 10, 'cover' => 'covers/8NfburzNwVA7MBeGa6ftmitDkrVlKzZDIXOtQKtZ.jpg'],
            ['judul' => 'Bumi Manusia', 'penulis' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun_penerbit' => 1980, 'kategori' => 'Fiksi', 'stok' => 5, 'cover' => 'covers/UxkPFjtVy2bJQZ6cRqZqYrdk0cqrhmTQEkpZ09VB.jpg'],
            ['judul' => 'Sapiens: Riwayat Singkat Umat Manusia', 'penulis' => 'Yuval Noah Harari', 'penerbit' => 'Gramedia', 'tahun_penerbit' => 2014, 'kategori' => 'Non-Fiksi', 'stok' => 8, 'cover' => 'covers/NBrxFyp7YHx4BJdTq57Lnl2CSofPviLhprDShcjz.jpg'],
            ['judul' => 'Pemrograman Web dengan Laravel', 'penulis' => 'Andi Prasetyo', 'penerbit' => 'Informatika', 'tahun_penerbit' => 2023, 'kategori' => 'Sains & Teknologi', 'stok' => 15],
            ['judul' => 'Sejarah Indonesia Modern', 'penulis' => 'M.C. Ricklefs', 'penerbit' => 'UGM Press', 'tahun_penerbit' => 2008, 'kategori' => 'Sejarah', 'stok' => 6, 'cover' => 'covers/kJLJZ3vtwEEi73XldrlwL9Z7T88SAalLLen49WqH.jpg'],
            ['judul' => 'Matematika Dasar untuk SMA', 'penulis' => 'Sukino', 'penerbit' => 'Erlangga', 'tahun_penerbit' => 2020, 'kategori' => 'Pendidikan', 'stok' => 20],
        ];

        foreach ($books as $book) {
            $categoryId = Kategori::where('nama_kategori', $book['kategori'])->value('id_kategori');
            if ($categoryId === null) {
                throw new \RuntimeException("Kategori {$book['kategori']} belum tersedia. Jalankan KategoriSeeder terlebih dahulu.");
            }

            $buku = Buku::firstOrCreate(
                ['judul' => $book['judul'], 'penerbit' => $book['penerbit']],
                [
                    'penulis' => $book['penulis'],
                    'tahun_penerbit' => $book['tahun_penerbit'],
                    'id_kategori' => $categoryId,
                    'stok' => $book['stok'],
                    'status' => 'tersedia',
                    'cover' => $book['cover'] ?? null,
                ]
            );

            if (
                empty($buku->cover)
                && ! empty($book['cover'])
                && is_file(storage_path('app/public/'.$book['cover']))
            ) {
                $buku->update(['cover' => $book['cover']]);
            }
        }
    }
}
