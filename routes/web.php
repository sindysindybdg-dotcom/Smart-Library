<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PetugasDashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PublikController;
use App\Http\Controllers\SiswaController;

// ==========================================
// 0. Route PUBLIK (Tanpa Login / Tamu)
// ==========================================
Route::get('/', [PublikController::class, 'beranda'])->name('publik.beranda');
Route::get('/katalog', [PublikController::class, 'katalog'])->name('publik.katalog');
Route::get('/detail-buku/{id}', [PublikController::class, 'detail'])->name('publik.detail');

// ✅ TAMBAHAN: Route untuk Halaman Panduan/Informasi
Route::get('/panduan', [PublikController::class, 'panduan'])->name('publik.panduan');

// ==========================================
// 1. Route Autentikasi (Login & Registrasi)
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.action');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.action');

// ==========================================
// 2. Route Khusus ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
    
    // Settings Management
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [SettingController::class, 'resetDefault'])->name('settings.reset');
});

// ==========================================
// 3. Route Khusus PETUGAS
// ==========================================
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard-petugas', [PetugasDashboardController::class, 'index'])->name('dashboard.petugas');
    
    // Buku
    Route::resource('buku', BukuController::class);
    
    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    
    // Pengembalian
    Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('pengembalian.index');
    Route::post('/pengembalian/proses', [PeminjamanController::class, 'prosesPengembalian'])->name('pengembalian.proses');
    
    // Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    
    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Laporan
    Route::get('/laporan', function() {
        return view('petugas.laporan.index');
    })->name('laporan.index');
});

// ==========================================
// 4. Route Khusus SISWA
// ==========================================
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'katalog'])->name('siswa.dashboard');
    Route::get('/siswa/profil', [SiswaController::class, 'profil'])->name('siswa.profil');
    Route::get('/siswa/riwayat', [SiswaController::class, 'riwayat'])->name('siswa.riwayat');
});

// ==========================================
// 5. Route Logout (Untuk Semua Role)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});