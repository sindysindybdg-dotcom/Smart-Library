@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <span class="badge-custom badge-warning" style="font-size: 10px;">ROOT PRIVILEGES</span>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue);">Tabel Database: settings (Key-Value)</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h2>Pengaturan Sistem & Kebijakan Perpustakaan</h2>
        <p>Konfigurasi parameter sirkulasi, durasi peminjaman, tarif sanksi/denda, pembatasan kuota, serta pemeliharaan keamanan database sistem.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-outline-custom" id="btnReset">
            <i class="bi bi-arrow-counterclockwise"></i> Pulihkan Default Pabrik
        </button>
        <button class="btn-primary-custom" id="btnSave">
            <i class="bi bi-save"></i> Simpan Semua Perubahan
        </button>
    </div>
</div>

<!-- Info Card -->
<div class="info-card">
    <div class="info-icon"><i class="bi bi-database-check"></i></div>
    <div class="info-content">
        <h5>
            Sinkronisasi Realtime MySQL Active
            <span class="badge-custom badge-success">Siap Terap</span>
        </h5>
        <p>Parameter disimpan secara terpusat pada tabel <code>settings</code> dan langsung diterapkan secara realtime pada modul Sirkulasi, Kiosk Siswa, & Pengembalian.</p>
    </div>
    <div class="info-right">
        <div>Versi Skema: <strong>v1.4.2-prod</strong></div>
        <div>Audit Log: <span class="badge-custom badge-success">Terekam (UID: 001)</span></div>
    </div>
</div>

<!-- Form Settings (FormData sudah handle multipart/form-data otomatis via JS) -->
<form id="formSettings">
    @csrf
    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Parameter Sirkulasi -->
            <div class="panel-card">
                <div class="panel-header">
                    <h5 class="panel-title">
                        <i class="bi bi-gear-fill me-2" style="color: var(--primary-blue);"></i>
                        Parameter Aturan Bisnis Sirkulasi
                        <span class="badge-custom badge-purple" style="margin-left: 8px;">Core Engine</span>
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="setting-card">
                                <label>Durasi Masa Peminjaman</label>
                                <div class="key-info"><span class="badge-custom badge-info" style="font-size: 9px;">BR-01</span> key: <code>loan_days</code></div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="loan_days" value="{{ $settings['loan_days'] ?? 7 }}" class="form-control" style="font-size: 13px; font-weight: 600;">
                                    <span style="font-size: 13px; color: var(--text-secondary);">Hari</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="setting-card">
                                <label>Batas Kuota Pinjam Siswa</label>
                                <div class="key-info"><span class="badge-custom badge-info" style="font-size: 9px;">BR-02</span> key: <code>max_loans</code></div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="max_loans" value="{{ $settings['max_loans'] ?? 3 }}" class="form-control" style="font-size: 13px; font-weight: 600;">
                                    <span style="font-size: 13px; color: var(--text-secondary);">Eksemplar</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="setting-card">
                                <label>Batas Kuota Guru & Tendik <span class="badge-custom badge-warning" style="font-size: 9px; margin-left: 4px;">Khusus</span></label>
                                <div class="key-info">key: <code>max_loans_teacher</code></div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="max_loans_teacher" value="{{ $settings['max_loans_teacher'] ?? 5 }}" class="form-control" style="font-size: 13px; font-weight: 600;">
                                    <span style="font-size: 13px; color: var(--text-secondary);">Eksemplar</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="setting-card">
                                <label>Tarif Denda Keterlambatan</label>
                                <div class="key-info"><span class="badge-custom badge-info" style="font-size: 9px;">BR-03</span> key: <code>fine_per_day</code></div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="fine_per_day" value="{{ $settings['fine_per_day'] ?? 1000 }}" class="form-control" style="font-size: 13px; font-weight: 600;">
                                    <span style="font-size: 13px; color: var(--text-secondary);">/ hari / buku</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="setting-card">
                                <label>Masa Toleransi Keterlambatan (Grace Period) <span class="badge-custom badge-purple" style="font-size: 9px;">Dispensasi</span></label>
                                <div class="key-info">key: <code>grace_period_days</code></div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="grace_period_days" value="{{ $settings['grace_period_days'] ?? 0 }}" class="form-control" style="width: 100px; font-size: 13px; font-weight: 600;">
                                    <span style="font-size: 13px; color: var(--text-secondary);">Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kebijakan Operasional -->
            <div class="panel-card">
                <div class="panel-header">
                    <h5 class="panel-title">
                        <i class="bi bi-shield-check me-2" style="color: var(--primary-blue);"></i>
                        Kebijakan Operasional Sirkulasi & Stok
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-title">
                                <i class="bi bi-slash-circle" style="color: #f59e0b;"></i>
                                Nonaktifkan Hak Pinjam Jika Denda > Rp10.000
                            </div>
                            <div class="toggle-desc">Sistem menolak transaksi baru bagi siswa dengan denda menunggak.</div>
                        </div>
                        <div class="form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" name="disable_loan_if_fine" {{ ($settings['disable_loan_if_fine'] ?? 1) == 1 ? 'checked' : '' }} style="width: 44px; height: 24px;">
                        </div>
                    </div>

                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-title">
                                <i class="bi bi-lock" style="color: var(--primary-blue);"></i>
                                Kunci Peminjaman Jika Stok Rak Tersisa 1
                            </div>
                            <div class="toggle-desc">Menjaga 1 eksemplar terakhir tetap di ruang baca.</div>
                        </div>
                        <div class="form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" name="lock_if_last_copy" {{ ($settings['lock_if_last_copy'] ?? 1) == 1 ? 'checked' : '' }} style="width: 44px; height: 24px;">
                        </div>
                    </div>

                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-title">
                                <i class="bi bi-shield" style="color: var(--text-secondary);"></i>
                                Aktifkan Soft Delete untuk Judul Berriwayat Pinjam
                                <span class="badge-custom badge-warning" style="font-size: 9px; margin-left: 4px;">WAJIB</span>
                            </div>
                            <div class="toggle-desc">Data buku ditandai <code>deleted_at</code>, tidak dihapus permanen.</div>
                        </div>
                        <div class="form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" name="soft_delete_enabled" checked disabled style="width: 44px; height: 24px;">
                        </div>
                    </div>

                    <div class="setting-card" style="margin-bottom: 0;">
                        <label>Jam Operasional Layanan Sirkulasi</label>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock" style="color: var(--text-secondary);"></i>
                                <input type="time" name="operational_start" value="{{ $settings['operational_start'] ?? '07:30' }}" class="form-control" style="width: 120px; font-size: 13px;">
                            </div>
                            <span style="color: var(--text-secondary);">s/d</span>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock" style="color: var(--text-secondary);"></i>
                                <input type="time" name="operational_end" value="{{ $settings['operational_end'] ?? '15:30' }}" class="form-control" style="width: 120px; font-size: 13px;">
                            </div>
                            <span style="font-size: 13px; color: var(--text-secondary);">WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WhatsApp -->
            <div class="panel-card">
                <div class="panel-header">
                    <h5 class="panel-title">
                        <i class="bi bi-whatsapp me-2" style="color: #10b981;"></i>
                        Integrasi WhatsApp & Notifikasi
                        <span class="badge-custom badge-success" style="margin-left: 8px;">Fonnte Gateway</span>
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="toggle-row" style="margin-bottom: 0;">
                                <div class="toggle-info">
                                    <div class="toggle-title">Pengingat Jatuh Tempo H-1</div>
                                    <div class="toggle-desc">Kirim WA otomatis jam 08:00 pagi.</div>
                                </div>
                                <div class="form-check form-switch ms-3">
                                    <input class="form-check-input" type="checkbox" name="wa_reminder_enabled" {{ ($settings['wa_reminder_enabled'] ?? 1) == 1 ? 'checked' : '' }} style="width: 44px; height: 24px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="toggle-row" style="margin-bottom: 0;">
                                <div class="toggle-info">
                                    <div class="toggle-title">Struk Sirkulasi Digital</div>
                                    <div class="toggle-desc">Kirim bukti peminjaman ke WA siswa.</div>
                                </div>
                                <div class="form-check form-switch ms-3">
                                    <input class="form-check-input" type="checkbox" name="wa_receipt_enabled" {{ ($settings['wa_receipt_enabled'] ?? 1) == 1 ? 'checked' : '' }} style="width: 44px; height: 24px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="setting-card" style="margin-bottom: 0;">
                                <label>Template Pesan Pengingat</label>
                                <small class="text-muted d-block mb-2">Variabel: {nama}, {judul_buku}, {tgl_kembali}</small>
                                <textarea name="wa_template_reminder" class="form-control" rows="3" style="font-size: 12px;">{{ $settings['wa_template_reminder'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            
            <!-- 🆕 IDENTITAS SEKOLAH (UPLOAD LOGO) -->
            <div class="panel-card">
                <div class="panel-header">
                    <h5 class="panel-title">
                        <i class="bi bi-building me-2" style="color: var(--primary-blue);"></i>
                        Identitas Sekolah
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="setting-card">
                        <label class="fw-bold">Logo Sekolah</label>
                        
                        @if(!empty($settings['logo']))
                            <div class="mb-3 text-center">
                                <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo Saat Ini" style="max-height: 80px; border: 1px solid #ddd; padding: 8px; border-radius: 8px; background: white;">
                                <small class="d-block text-muted mt-1">Logo saat ini. Upload baru untuk mengganti.</small>
                            </div>
                        @endif

                        <input type="file" name="logo" class="form-control" accept="image/png, image/jpeg, image/jpg">
                        <small class="text-muted">Format: PNG, JPG. Maksimal 2MB. (Rasio 1:1 disarankan)</small>
                    </div>
                </div>
            </div>
            <!-- 🆕 AKHIR IDENTITAS SEKOLAH -->

            <!-- Database -->
            <div class="panel-card">
                <div class="panel-header">
                    <h5 class="panel-title">
                        <i class="bi bi-database me-2" style="color: #f59e0b;"></i>
                        Pemeliharaan Database
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="setting-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge-custom badge-success" style="font-size: 9px;">TERVERIFIKASI</span>
                            <span style="font-size: 11px; color: var(--text-secondary);">Status Snapshot DB</span>
                        </div>
                        <div style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">smartlib_backup.sql</div>
                        <div style="font-size: 11px; color: var(--text-secondary); margin-bottom: 12px;">Ukuran: <strong>18.4 MB</strong> • Hari ini, 03:00 WIB</div>
                        <button type="button" class="btn-outline-custom w-100" style="font-size: 12px; padding: 8px; justify-content: center;">
                            <i class="bi bi-download"></i> Unduh Cadangan (.SQL)
                        </button>
                    </div>
                    <div class="setting-card" style="margin-bottom: 0;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-clock-history" style="color: var(--text-secondary);"></i>
                            <span style="font-size: 12px; font-weight: 600;">Otomasi Cron Backup</span>
                            <span class="badge-custom badge-success" style="margin-left: auto; font-size: 9px;">AKTIF</span>
                        </div>
                        <small style="font-size: 11px; color: var(--text-secondary);">Setiap hari pukul <strong>03:00 WIB</strong></small>
                    </div>
                </div>
            </div>

            <!-- Keamanan -->
            <div class="panel-card">
                <div class="panel-header">
                    <h5 class="panel-title">
                        <i class="bi bi-shield-lock me-2" style="color: #ef4444;"></i>
                        Keamanan & Sesi Akses
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="setting-card">
                        <label>Session Idle Timeout</label>
                        <div class="key-info">session_lifetime</div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" name="session_lifetime" value="{{ $settings['session_lifetime'] ?? 60 }}" class="form-control" style="font-size: 13px; font-weight: 600;">
                            <span style="font-size: 13px; color: var(--text-secondary);">Menit</span>
                        </div>
                    </div>

                    <div class="setting-card">
                        <label>Brute-Force Rate Limiting</label>
                        <div class="key-info">max_login_attempts</div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" name="max_login_attempts" value="{{ $settings['max_login_attempts'] ?? 5 }}" class="form-control" style="font-size: 13px; font-weight: 600;">
                            <span style="font-size: 13px; color: var(--text-secondary);">percobaan/mnt</span>
                        </div>
                    </div>

                    <div style="background: #dcfce7; border-radius: 10px; padding: 16px;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 16px;"></i>
                            <strong style="font-size: 12px; color: #10b981;">CSRF & XSS Protection On</strong>
                        </div>
                        <small style="font-size: 11px; color: var(--text-secondary); line-height: 1.5;">Token CSRF diverifikasi per transaksi HTTP PUT/POST sesuai OWASP.</small>
                    </div>
                </div>
            </div>

            <!-- Server Card -->
            <div class="server-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="server-title">KAPASITAS SERVER SMK</div>
                        <div class="server-name">Server Lokal Node-01</div>
                    </div>
                    <i class="bi bi-hdd-network" style="font-size: 20px; opacity: 0.8;"></i>
                </div>
                <div class="server-spec">PHP 8.2 • MariaDB 10.11 • SSD NVMe</div>
                <div style="font-size: 11px; opacity: 0.8; margin-bottom: 4px;">Penyimpanan Terpakai</div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span style="font-size: 13px; font-weight: 700;">24% (12.4 GB / 50 GB)</span>
                    <span style="font-size: 11px; opacity: 0.8;">(DB + Cover)</span>
                </div>
                <div class="progress" style="height: 6px; background: rgba(255,255,255,0.2); border-radius: 3px;">
                    <div class="progress-bar" style="width: 24%; background: white; border-radius: 3px;"></div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Save Settings
document.getElementById('btnSave').addEventListener('click', function(e) {
    e.preventDefault();
    const btn = this;
    const form = document.getElementById('formSettings');
    
    // ✅ FormData OTOMATIS menangani file upload (multipart/form-data)
    const formData = new FormData(form);
    
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    btn.disabled = true;
    
    fetch('{{ route("settings.update") }}', {
        method: 'POST',
        body: formData, // ✅ Ini kunci agar file logo terkirim
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.innerHTML = '<i class="bi bi-check-circle"></i> Tersimpan!';
            btn.style.background = '#10b981';
            setTimeout(() => {
                location.reload(); // ✅ Refresh halaman agar logo baru langsung muncul
            }, 1000);
        } else {
            alert('❌ Gagal: ' + data.message);
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat menyimpan.');
        btn.disabled = false;
    });
});

// Reset to Default
document.getElementById('btnReset').addEventListener('click', function(e) {
    e.preventDefault();
    if (!confirm('⚠️ Yakin ingin mengembalikan SEMUA pengaturan ke default pabrik?\n\nTindakan ini tidak dapat dibatalkan!')) return;
    
    const btn = this;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mereset...';
    btn.disabled = true;
    
    fetch('{{ route("settings.reset") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Pengaturan dikembalikan ke default!');
            location.reload();
        }
    })
    .catch(error => {
        alert('❌ Gagal mereset pengaturan.');
        btn.disabled = false;
    });
});
</script>
@endpush