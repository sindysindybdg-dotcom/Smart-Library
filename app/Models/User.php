<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'nama',
        'id_role',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login' => 'datetime',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_user', 'id_user');
    }

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'id_user', 'id_user');
    }
}