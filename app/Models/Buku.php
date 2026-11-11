<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'judul',
        'pengarang',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'tahun_penerbit',
        'kategori_id',
        'id_kategori',
        'lokasi_rak',
        'stok',
        'status',
        'cover',
        'isbn',
        'kode_buku',
        'nomor_isbn',
        'barcode',
    ];

    protected $casts = [
        'stok' => 'integer',
        'tahun_terbit' => 'integer',
        'tahun_penerbit' => 'integer',
    ];

    public function kategori()
    {
        $foreignKey = Schema::hasColumn('bukus', 'id_kategori') ? 'id_kategori' : 'kategori_id';
        return $this->belongsTo(Kategori::class, $foreignKey, 'id_kategori');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_buku', 'id_buku');
    }
}