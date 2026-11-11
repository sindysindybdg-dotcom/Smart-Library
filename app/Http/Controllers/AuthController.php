<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 1. Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials + ['status' => 'aktif'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            $user->update(['last_login' => now()]);

            $roleName = strtolower($user->role->nama_role ?? 'anggota');
            $roleId = $user->id_role ?? 3;

            if ($roleName === 'admin' || $roleId == 1) {
                return redirect()->intended(route('dashboard'));
            } elseif ($roleName === 'petugas' || $roleId == 2) {
                return redirect()->intended(route('dashboard.petugas'));
            } elseif ($roleName === 'siswa' || $roleName === 'anggota' || $roleId == 3) {
                return redirect()->intended(route('siswa.dashboard'));
            }

            return redirect()->intended(route('siswa.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // 3. Proses registrasi anggota baru
    public function register(Request $request)
    {
        $validated = $request->validate([
            'tipe_anggota' => 'required|in:siswa,guru',
            'nomor_induk' => 'required|unique:anggotas,nomor_induk|max:20',
            'nama' => 'required|max:100',
            'kelas' => 'required|max:20',
            'whatsapp' => 'required|max:20',
            'email' => 'required|email|unique:anggotas,email|max:100',
            'password' => 'required|min:8|confirmed',
            'agree' => 'required|accepted',
        ]);

        DB::transaction(function () use ($validated) {
            $username = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $validated['nomor_induk']));
            if (User::where('username', $username)->exists()) {
                $username .= '_'.Str::lower(Str::random(8));
            }

            $user = User::create([
                'username' => $username,
                'password' => Hash::make($validated['password']),
                'nama' => $validated['nama'],
                'id_role' => 3,
                'status' => 'aktif',
            ]);

            Anggota::create([
                'user_id' => $user->id_user,
                'nis' => $validated['nomor_induk'],
                'nomor_induk' => $validated['nomor_induk'],
                'nama' => $validated['nama'],
                'kelas' => $validated['kelas'],
                'whatsapp' => $validated['whatsapp'],
                'email' => $validated['email'],
                'tipe' => $validated['tipe_anggota'],
                'status' => 'aktif',
            ]);
        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    // 4. Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
