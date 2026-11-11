<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        
        // 2. Ambil nilai role dari user (cek id_role dulu, lalu role)
        // Prioritas: id_role (angka) > role (text)
        $roleId = $user->id_role ?? null;
        $roleName = $user->role ?? null;
        
        // Jika ada relasi $user->role->nama_role
        if (!$roleName && isset($user->role->nama_role)) {
            $roleName = $user->role->nama_role;
        }
        
        // 3. Mapping role yang diizinkan
        $allowedRoles = [
            'admin'   => ['1', 'admin', 'administrator'],
            'petugas' => ['2', 'petugas', 'officer', 'staff'],
            'siswa'   => ['3', 'siswa', 'student', 'anggota', 'member'],
        ];

        // 4. Cek berdasarkan roleId atau roleName
        $userRoleValue = $roleId ?? $roleName ?? 'unknown';
        
        if (!in_array((string)$userRoleValue, $allowedRoles[$role] ?? [])) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk membuka halaman ini.');
        }

        return $next($request);
    }
}