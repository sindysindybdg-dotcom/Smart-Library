<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamen';

    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'id_anggota',
        'tgl_peminjaman',
        'tgl_jatuh_tempo',
        'status',
    ];

    protected $casts = [
        'tgl_peminjaman' => 'date',
        'tgl_jatuh_tempo' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    // Relasi ke Detail Peminjaman (Buku-buku yang dipinjam)
    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman', 'id_peminjaman');
    }

    // Helper untuk mengambil buku pertama (untuk kompatibilitas dengan dashboard)
    public function buku()
    {
        return $this->hasOneThrough(
            Buku::class,
            DetailPeminjaman::class,
            'id_peminjaman', // Foreign key on detail table
            'id_buku',       // Foreign key on buku table
            'id_peminjaman', // Local key on peminjaman table
            'id_buku'        // Local key on detail table
        );
    }
}
