<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $primaryKey = 'id_pengembalian';

    protected $fillable = [
        'id_peminjaman',
        'id_user',
        'tgl_pengembalian',
        'denda',
        'status_pengembalian',
    ];

    protected function casts(): array
    {
        return [
            'tgl_pengembalian' => 'date',
            'denda' => 'decimal:2',
        ];
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}