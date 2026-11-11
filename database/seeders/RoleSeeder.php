<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'admin' => 'Administrator sistem - Akses penuh ke semua fitur',
            'petugas' => 'Petugas perpustakaan - Mengelola peminjaman dan buku',
            'anggota' => 'Anggota perpustakaan - Dapat meminjam buku',
        ] as $nama => $deskripsi) {
            Role::firstOrCreate(
                ['nama_role' => $nama],
                ['deskripsi' => $deskripsi]
            );
        }
    }
}
