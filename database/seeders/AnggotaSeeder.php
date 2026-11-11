<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['nis' => '2024001', 'nama' => 'Ahmad Rizki', 'kelas' => 'XII IPA 1', 'alamat' => 'Jl. Merdeka No. 10, Jakarta', 'no_telepon' => '081234567890'],
            ['nis' => '2024002', 'nama' => 'Dewi Lestari', 'kelas' => 'XII IPA 2', 'alamat' => 'Jl. Sudirman No. 25, Jakarta', 'no_telepon' => '081234567891'],
            ['nis' => '2024003', 'nama' => 'Bambang Irawan', 'kelas' => 'XI IPS 1', 'alamat' => 'Jl. Gatot Subroto No. 15, Jakarta', 'no_telepon' => '081234567892'],
            ['nis' => '2024004', 'nama' => 'Citra Kirana', 'kelas' => 'X MIPA 1', 'alamat' => 'Jl. Thamrin No. 30, Jakarta', 'no_telepon' => '081234567893'],
        ];

        foreach ($members as $member) {
            Anggota::firstOrCreate(
                ['nis' => $member['nis']],
                $member + [
                    'nomor_induk' => $member['nis'],
                    'status' => 'aktif',
                ]
            );
        }
    }
}
