<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Sirkulasi
            ['setting_key' => 'loan_days', 'setting_value' => '7', 'setting_type' => 'number', 'group' => 'sirkulasi'],
            ['setting_key' => 'max_loans', 'setting_value' => '3', 'setting_type' => 'number', 'group' => 'sirkulasi'],
            ['setting_key' => 'max_loans_teacher', 'setting_value' => '5', 'setting_type' => 'number', 'group' => 'sirkulasi'],
            ['setting_key' => 'fine_per_day', 'setting_value' => '1000', 'setting_type' => 'number', 'group' => 'sirkulasi'],
            ['setting_key' => 'grace_period_days', 'setting_value' => '0', 'setting_type' => 'number', 'group' => 'sirkulasi'],
            ['setting_key' => 'operational_start', 'setting_value' => '07:30', 'setting_type' => 'string', 'group' => 'sirkulasi'],
            ['setting_key' => 'operational_end', 'setting_value' => '15:30', 'setting_type' => 'string', 'group' => 'sirkulasi'],

            // Kebijakan
            ['setting_key' => 'disable_loan_if_fine', 'setting_value' => '1', 'setting_type' => 'boolean', 'group' => 'kebijakan'],
            ['setting_key' => 'lock_if_last_copy', 'setting_value' => '1', 'setting_type' => 'boolean', 'group' => 'kebijakan'],
            ['setting_key' => 'soft_delete_enabled', 'setting_value' => '1', 'setting_type' => 'boolean', 'group' => 'kebijakan'],

            // WhatsApp
            ['setting_key' => 'wa_reminder_enabled', 'setting_value' => '1', 'setting_type' => 'boolean', 'group' => 'whatsapp'],
            ['setting_key' => 'wa_receipt_enabled', 'setting_value' => '1', 'setting_type' => 'boolean', 'group' => 'whatsapp'],
            ['setting_key' => 'wa_template_reminder', 'setting_value' => 'Halo {nama}, besok ({tgl_kembali}) adalah batas akhir peminjaman buku "{judul_buku}" di Perpustakaan SMK Budi Bakti Ciwidey. Harap mengembalikan tepat waktu untuk menghindari sanksi denda Rp1.000/hari.', 'setting_type' => 'string', 'group' => 'whatsapp'],

            // Keamanan
            ['setting_key' => 'session_lifetime', 'setting_value' => '60', 'setting_type' => 'number', 'group' => 'keamanan'],
            ['setting_key' => 'max_login_attempts', 'setting_value' => '5', 'setting_type' => 'number', 'group' => 'keamanan'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['setting_key' => $setting['setting_key']],
                [
                    'setting_value' => $setting['setting_value'],
                    'setting_type' => $setting['setting_type'],
                    'group' => $setting['group'],
                    'updated_at' => now(),
                ]
            );
        }
    }
}
