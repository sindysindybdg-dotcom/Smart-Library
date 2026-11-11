<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    // Primary key sesuai struktur database kamu
    protected $primaryKey = 'id_anggota';

    // ✅ DIPERBAIKI: Semua kolom yang dipakai di AuthController::register WAJIB ada di sini!
    protected $fillable = [
        'nis',
        'user_id',
        'nomor_induk',
        'nama',
        'kelas',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'no_hp',
        'whatsapp',
        'email',
        'tipe',
        'status',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // Relasi ke tabel peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }
}
