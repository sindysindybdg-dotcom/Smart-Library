<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'admin', 'nama' => 'Administrator', 'role' => 'admin', 'password' => 'admin123'],
            ['username' => 'petugas1', 'nama' => 'Budi Santoso', 'role' => 'petugas', 'password' => 'petugas123'],
            ['username' => 'petugas2', 'nama' => 'Siti Aminah', 'role' => 'petugas', 'password' => 'petugas123'],
        ];

        foreach ($users as $user) {
            $roleId = Role::where('nama_role', $user['role'])->value('id_role');
            if ($roleId === null) {
                throw new \RuntimeException("Role {$user['role']} belum tersedia. Jalankan RoleSeeder terlebih dahulu.");
            }

            User::firstOrCreate(
                ['username' => $user['username']],
                [
                    'password' => Hash::make($user['password']),
                    'nama' => $user['nama'],
                    'id_role' => $roleId,
                    'status' => 'aktif',
                ]
            );
        }
    }
}
