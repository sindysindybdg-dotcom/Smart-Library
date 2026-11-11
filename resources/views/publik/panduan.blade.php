@extends('layouts.publik')

@section('title', 'Panduan & Informasi Perpustakaan')

@section('content')
<div class="container py-4 py-md-5">
    <!-- Header -->
    <div class="text-center mb-4 mb-md-5">
        <h1 class="fw-bold mb-3" style="font-size: clamp(1.5rem, 4vw, 2.5rem); line-height: 1.2;">Panduan & Informasi Perpustakaan</h1>
        <p class="text-muted mb-0" style="font-size: clamp(0.9rem, 2vw, 1rem); max-width: 700px; margin: 0 auto;">Pelajari tata tertib, alur peminjaman, dan informasi lengkap Smart Library SMK Budi Bakti Ciwidey</p>
    </div>

    <!-- Info Cards - RESPONSIVE: 2 kolom di HP, 4 di desktop -->
    <div class="row g-3 g-md-4 mb-4 mb-md-5">
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="bi bi-clock" style="font-size: clamp(32px, 8vw, 48px); color: #2563eb;"></i>
                    <h5 class="mt-2 mt-md-3 fw-bold" style="font-size: 1rem;">Jam Operasional</h5>
                    <p class="text-muted mb-0" style="font-size: 0.8rem;">Senin - Jumat</p>
                    <p class="fw-bold mb-0" style="font-size: 0.9rem;">07:30 - 16:00 WIB</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="bi bi-geo-alt" style="font-size: clamp(32px, 8vw, 48px); color: #2563eb;"></i>
                    <h5 class="mt-2 mt-md-3 fw-bold" style="font-size: 1rem;">Lokasi</h5>
                    <p class="text-muted mb-0" style="font-size: 0.8rem;">Gedung Perpustakaan</p>
                    <p class="fw-bold mb-0" style="font-size: 0.9rem;">Lantai 2, SMK Budi Bakti</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="bi bi-telephone" style="font-size: clamp(32px, 8vw, 48px); color: #2563eb;"></i>
                    <h5 class="mt-2 mt-md-3 fw-bold" style="font-size: 1rem;">Kontak</h5>
                    <p class="text-muted mb-0" style="font-size: 0.8rem;">WhatsApp Petugas</p>
                    <p class="fw-bold mb-0" style="font-size: 0.9rem;">0812-3456-7890</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="bi bi-envelope" style="font-size: clamp(32px, 8vw, 48px); color: #2563eb;"></i>
                    <h5 class="mt-2 mt-md-3 fw-bold" style="font-size: 1rem;">Email</h5>
                    <p class="text-muted mb-0" style="font-size: 0.8rem;">Perpustakaan</p>
                    <p class="fw-bold mb-0" style="font-size: 0.9rem;">perpus@smkbudibakti.sch.id</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alur Peminjaman - RESPONSIVE: 2 kolom di HP, 4 di desktop -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3 p-md-4">
            <h3 class="fw-bold mb-4" style="font-size: clamp(1.1rem, 3vw, 1.5rem);">
                <i class="bi bi-arrow-right-circle text-primary"></i> Alur Peminjaman Buku
            </h3>
            <div class="row g-3">
                <div class="col-6 col-md-3 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                         style="width: clamp(48px, 12vw, 60px); height: clamp(48px, 12vw, 60px); font-size: clamp(18px, 5vw, 24px); font-weight: bold;">1</div>
                    <h6 class="fw-bold" style="font-size: 0.95rem;">Cari Buku</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.8rem;">Telusuri katalog online atau datang langsung</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                         style="width: clamp(48px, 12vw, 60px); height: clamp(48px, 12vw, 60px); font-size: clamp(18px, 5vw, 24px); font-weight: bold;">2</div>
                    <h6 class="fw-bold" style="font-size: 0.95rem;">Datang ke Perpus</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.8rem;">Bawa kartu anggota & tunjukkan buku</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                         style="width: clamp(48px, 12vw, 60px); height: clamp(48px, 12vw, 60px); font-size: clamp(18px, 5vw, 24px); font-weight: bold;">3</div>
                    <h6 class="fw-bold" style="font-size: 0.95rem;">Proses Peminjaman</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.8rem;">Petugas memproses & beri bukti pinjam</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                         style="width: clamp(48px, 12vw, 60px); height: clamp(48px, 12vw, 60px); font-size: clamp(18px, 5vw, 24px); font-weight: bold;">4</div>
                    <h6 class="fw-bold" style="font-size: 0.95rem;">Kembalikan Tepat Waktu</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.8rem;">Maksimal 7 hari untuk hindari denda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tata Tertib -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3 p-md-4">
            <h3 class="fw-bold mb-4" style="font-size: clamp(1.1rem, 3vw, 1.5rem);">
                <i class="bi bi-shield-check text-primary"></i> Tata Tertib Perpustakaan
            </h3>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="d-flex mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1" style="font-size: 18px;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Wajib Membawa Kartu Anggota</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Setiap peminjaman harus menggunakan kartu anggota yang masih aktif</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1" style="font-size: 18px;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Maksimal 3 Buku Sekaligus</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Setiap anggota hanya boleh meminjam maksimal 3 buku dalam waktu bersamaan</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1" style="font-size: 18px;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Jaga Kebersihan Buku</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Dilarang mencoret, merobek, atau merusak buku dalam bentuk apapun</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1" style="font-size: 18px;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Dilarang Memindahkan Rak</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Setelah membaca di tempat, kembalikan buku ke posisi semula</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1" style="font-size: 18px;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Jaga Ketertiban</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Dilarang membuat gaduh atau mengganggu pengunjung lain</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1" style="font-size: 18px;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Dilarang Makan & Minum</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Tidak diperbolehkan membawa makanan dan minuman ke area perpustakaan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aturan Denda - RESPONSIVE: 1 kolom di HP, 3 di desktop -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3 p-md-4">
            <h3 class="fw-bold mb-4" style="font-size: clamp(1.1rem, 3vw, 1.5rem);">
                <i class="bi bi-exclamation-triangle text-warning"></i> Aturan Denda & Sanksi
            </h3>
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-clock-history text-warning" style="font-size: clamp(24px, 6vw, 32px);"></i>
                            <h5 class="ms-2 mb-0 fw-bold" style="font-size: 1rem;">Keterlambatan</h5>
                        </div>
                        <p class="text-muted small mb-2" style="font-size: 0.85rem;">Mengembalikan buku melebihi batas waktu 7 hari</p>
                        <div class="fw-bold text-danger" style="font-size: 0.95rem;">Denda Rp1.000/hari</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-book text-danger" style="font-size: clamp(24px, 6vw, 32px);"></i>
                            <h5 class="ms-2 mb-0 fw-bold" style="font-size: 1rem;">Buku Hilang</h5>
                        </div>
                        <p class="text-muted small mb-2" style="font-size: 0.85rem;">Kehilangan buku yang dipinjam</p>
                        <div class="fw-bold text-danger" style="font-size: 0.95rem;">Ganti buku baru atau bayar 2x harga buku</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-x-circle text-danger" style="font-size: clamp(24px, 6vw, 32px);"></i>
                            <h5 class="ms-2 mb-0 fw-bold" style="font-size: 1rem;">Buku Rusak</h5>
                        </div>
                        <p class="text-muted small mb-2" style="font-size: 0.85rem;">Merusak buku (sobek, coret, basah)</p>
                        <div class="fw-bold text-danger" style="font-size: 0.95rem;">Denda Rp5.000 - Rp50.000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3 p-md-4">
            <h3 class="fw-bold mb-4" style="font-size: clamp(1.1rem, 3vw, 1.5rem);">
                <i class="bi bi-question-circle text-primary"></i> Pertanyaan yang Sering Diajukan (FAQ)
            </h3>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" style="font-size: 0.95rem;">
                            <strong>Bagaimana cara mendaftar menjadi anggota?</strong>
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="font-size: 0.9rem;">
                            Klik tombol <strong>"Daftar Anggota"</strong> di halaman utama, isi formulir dengan data lengkap (NISN, nama, kelas, email, WhatsApp), lalu tunggu verifikasi dari petugas perpustakaan.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" style="font-size: 0.95rem;">
                            <strong>Berapa lama batas waktu peminjaman buku?</strong>
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="font-size: 0.9rem;">
                            Setiap buku dapat dipinjam selama <strong>7 hari kalender</strong>. Jika terlambat mengembalikan, akan dikenakan denda Rp1.000 per hari.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" style="font-size: 0.95rem;">
                            <strong>Apakah bisa memperpanjang masa peminjaman?</strong>
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="font-size: 0.9rem;">
                            Ya, Anda bisa memperpanjang masa peminjaman dengan datang ke perpustakaan sebelum batas waktu habis. Perpanjangan maksimal <strong>7 hari tambahan</strong> dengan syarat buku tidak ada yang memesan.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" style="font-size: 0.95rem;">
                            <strong>Bagaimana jika kartu anggota hilang?</strong>
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="font-size: 0.9rem;">
                            Segera laporkan ke petugas perpustakaan untuk pemblokiran kartu lama dan pembuatan kartu baru. Biaya pembuatan kartu pengganti <strong>Rp5.000</strong>.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" style="font-size: 0.95rem;">
                            <strong>Apakah ada denda jika buku hilang?</strong>
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="font-size: 0.9rem;">
                            Ya, jika buku hilang Anda wajib <strong>mengganti dengan buku baru yang sama</strong> atau membayar <strong>2x harga buku</strong> tersebut. Silakan konsultasikan dengan petugas perpustakaan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection