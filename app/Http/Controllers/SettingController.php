<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsArray();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Ambil semua data kecuali token dan method
        $data = $request->except(['_token', '_method']);

        // ==========================================
        // 1. HANDLE UPLOAD LOGO SEKOLAH
        // ==========================================
        if ($request->hasFile('logo')) {
            // Ambil logo lama untuk dihapus (opsional, agar tidak menumpuk)
            $oldLogo = Setting::get('logo'); 
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Simpan file baru ke storage/app/public/logos
            $path = $request->file('logo')->store('logos', 'public');
            
            // Ganti object file di array $data dengan path string
            $data['logo'] = $path;
        } else {
            // Jika tidak ada file baru yang diupload, hapus key 'logo' dari $data
            // agar nilai logo lama di database tidak tertimpa menjadi kosong/null
            unset($data['logo']);
        }
        // ==========================================

        foreach ($data as $key => $value) {
            // Handle checkbox (boolean)
            if (is_array($value)) {
                $value = 1;
            }
            
            // Jika checkbox tidak dicentang, set 0
            if (in_array($key, ['disable_loan_if_fine', 'lock_if_last_copy', 'soft_delete_enabled', 'wa_reminder_enabled', 'wa_receipt_enabled'])) {
                $value = $request->has($key) ? 1 : 0;
            }

            Setting::set($key, $value);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan!'
        ]);
    }

    public function resetDefault()
    {
        // Hapus semua dan jalankan seeder ulang
        Setting::truncate();
        (new \Database\Seeders\SettingsSeeder())->run();

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan dikembalikan ke default!'
        ]);
    }
}