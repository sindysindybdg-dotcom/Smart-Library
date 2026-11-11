<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Fiksi' => 'Novel, cerpen, dan karya fiksi lainnya',
            'Non-Fiksi' => 'Buku ilmiah, biografi, dan fakta',
            'Sains & Teknologi' => 'Buku tentang sains, teknologi, dan komputer',
            'Sejarah' => 'Buku tentang sejarah dan peradaban',
            'Agama' => 'Buku tentang agama dan spiritualitas',
            'Pendidikan' => 'Buku pelajaran dan referensi pendidikan',
        ];

        foreach ($categories as $nama => $deskripsi) {
            Kategori::firstOrCreate(
                ['nama_kategori' => $nama],
                ['deskripsi' => $deskripsi]
            );
        }
    }
}
