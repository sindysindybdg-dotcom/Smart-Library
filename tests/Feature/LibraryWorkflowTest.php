<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LibraryWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_a_linked_user_and_member(): void
    {
        $this->createRole(3, 'anggota');

        $response = $this->post(route('register.action'), [
            'tipe_anggota' => 'siswa',
            'nomor_induk' => '2026-001',
            'nama' => 'Siswa Contoh',
            'kelas' => 'X PPLG 1',
            'whatsapp' => '081234567890',
            'email' => 'siswa@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => 'yes',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', ['username' => '2026001', 'id_role' => 3]);
        $this->assertDatabaseHas('anggotas', [
            'nomor_induk' => '2026-001',
            'nis' => '2026-001',
            'email' => 'siswa@example.test',
            'user_id' => User::where('username', '2026001')->value('id_user'),
        ]);
    }

    public function test_petugas_can_borrow_and_return_a_book_only_once(): void
    {
        $this->createRole(2, 'petugas');
        $petugas = User::create([
            'username' => 'petugas',
            'password' => 'password123',
            'nama' => 'Petugas Contoh',
            'id_role' => 2,
            'status' => 'aktif',
        ]);
        $kategori = Kategori::create(['nama_kategori' => 'Fiksi']);
        $anggota = Anggota::create([
            'nis' => '2026002',
            'nomor_induk' => '2026002',
            'nama' => 'Anggota Contoh',
            'kelas' => 'X PPLG 1',
            'status' => 'aktif',
        ]);
        $buku = Buku::create([
            'judul' => 'Buku Tes',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun_penerbit' => 2025,
            'id_kategori' => $kategori->id_kategori,
            'stok' => 1,
            'status' => 'tersedia',
            'isbn' => 'TEST-ISBN-1',
        ]);

        $this->actingAs($petugas)->post(route('peminjaman.store'), [
            'id_anggota' => $anggota->id_anggota,
            'id_buku' => $buku->id_buku,
            'tanggal_pinjam' => '2026-11-07',
            'tanggal_kembali' => '2026-11-14',
        ])->assertRedirect(route('dashboard.petugas'));

        $this->assertDatabaseHas('bukus', ['id_buku' => $buku->id_buku, 'stok' => 0]);
        $peminjamanId = DB::table('peminjamen')->value('id_peminjaman');

        $this->post(route('pengembalian.proses'), ['id_peminjaman' => $peminjamanId])
            ->assertRedirect(route('dashboard.petugas'));
        $this->assertDatabaseHas('peminjamen', [
            'id_peminjaman' => $peminjamanId,
            'status' => 'dikembalikan',
        ]);
        $this->assertDatabaseHas('pengembalians', [
            'id_peminjaman' => $peminjamanId,
            'id_user' => $petugas->id_user,
            'denda' => 0,
            'status_pengembalian' => 'lunas',
        ]);
        $this->assertDatabaseHas('bukus', ['id_buku' => $buku->id_buku, 'stok' => 1]);

        $this->from(route('pengembalian.index'))
            ->post(route('pengembalian.proses'), ['id_peminjaman' => $peminjamanId])
            ->assertSessionHasErrors('id_peminjaman');
        $this->assertDatabaseHas('bukus', ['id_buku' => $buku->id_buku, 'stok' => 1]);

        $this->get(route('dashboard.petugas'))->assertOk();
        $this->get(route('peminjaman.index'))->assertOk();
        $this->get(route('peminjaman.create'))->assertOk();
        $this->get(route('peminjaman.edit', $peminjamanId))->assertOk();
        $this->get(route('buku.index'))->assertOk();
        $this->get(route('buku.create'))->assertOk();
        $this->get(route('anggota.index'))->assertOk();
        $this->get(route('anggota.create'))->assertOk();
        $this->get(route('kategori.index'))->assertOk();
        $this->get(route('kategori.create'))->assertOk();
        $this->get(route('laporan.index'))->assertOk();
    }

    public function test_student_can_filter_catalog_by_category(): void
    {
        $this->createRole(3, 'anggota');
        $student = User::create([
            'username' => 'siswa',
            'password' => 'password123',
            'nama' => 'Siswa Contoh',
            'id_role' => 3,
            'status' => 'aktif',
        ]);
        $fiksi = Kategori::create(['nama_kategori' => 'Fiksi']);
        $sejarah = Kategori::create(['nama_kategori' => 'Sejarah']);
        $fiksiBook = Buku::create([
            'judul' => 'Novel Fiksi',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun_penerbit' => 2025,
            'id_kategori' => $fiksi->id_kategori,
            'stok' => 1,
            'status' => 'tersedia',
        ]);
        Buku::create([
            'judul' => 'Buku Sejarah',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun_penerbit' => 2025,
            'id_kategori' => $sejarah->id_kategori,
            'stok' => 1,
            'status' => 'tersedia',
        ]);

        $this->actingAs($student)
            ->get(route('siswa.dashboard', ['kategori' => $fiksi->id_kategori]))
            ->assertOk()
            ->assertViewHas('bukus', fn ($bukus) => $bukus->pluck('id_buku')->all() === [$fiksiBook->id_buku]);

        $this->get(route('siswa.riwayat'))->assertOk();
        $this->get(route('siswa.profil'))->assertOk();
        $this->get(route('publik.katalog'))->assertOk();
        $this->get(route('publik.detail', $fiksiBook->id_buku))->assertOk();
        $this->get(route('publik.panduan'))->assertOk();
        $this->get(route('publik.katalog', ['q' => 'tidak-ada-hasil']))
            ->assertOk()
            ->assertViewHas('bukus', fn ($bukus) => $bukus->isEmpty());
        $this->get(route('publik.detail', 999999))->assertNotFound();
    }

    public function test_public_homepage_shows_live_catalog_and_active_member_counts(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Fiksi']);
        Buku::create([
            'judul' => 'Buku Satu',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun_penerbit' => 2025,
            'id_kategori' => $kategori->id_kategori,
            'stok' => 1,
            'status' => 'tersedia',
        ]);
        Buku::create([
            'judul' => 'Buku Dua',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun_penerbit' => 2025,
            'id_kategori' => $kategori->id_kategori,
            'stok' => 1,
            'status' => 'tersedia',
        ]);
        Anggota::create([
            'nis' => '2026004',
            'nomor_induk' => '2026004',
            'nama' => 'Anggota Aktif',
            'kelas' => 'X PPLG 1',
            'status' => 'aktif',
        ]);
        Anggota::create([
            'nis' => '2026005',
            'nomor_induk' => '2026005',
            'nama' => 'Anggota Nonaktif',
            'kelas' => 'X PPLG 1',
            'status' => 'nonaktif',
        ]);

        $this->get(route('publik.beranda'))
            ->assertOk()
            ->assertViewHas('totalBuku', 2)
            ->assertViewHas('totalAnggotaAktif', 1)
            ->assertSee('data-stat="books"', false)
            ->assertSee('data-stat="active-members"', false);
    }

    public function test_public_book_detail_uses_real_recommendations_and_labels_missing_metadata(): void
    {
        $fiksi = Kategori::create(['nama_kategori' => 'Fiksi']);
        $buku = Buku::create([
            'judul' => 'Novel Contoh',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun_penerbit' => 2025,
            'id_kategori' => $fiksi->id_kategori,
            'stok' => 1,
            'status' => 'tersedia',
        ]);
        $relatedBook = Buku::create([
            'judul' => 'Novel Fiksi Lain',
            'penulis' => 'Penulis Lain',
            'penerbit' => 'Penerbit',
            'tahun_penerbit' => 2024,
            'id_kategori' => $fiksi->id_kategori,
            'stok' => 0,
            'status' => 'tidak_tersedia',
        ]);

        $this->get(route('publik.detail', $buku->id_buku))
            ->assertOk()
            ->assertSee('Novel Fiksi Lain')
            ->assertSee('Lokasi rak belum diatur')
            ->assertDontSee('Algoritma & Pemrograman Python Terapan')
            ->assertViewHas('rekomendasi', fn ($rekomendasi) => $rekomendasi->pluck('id_buku')->all() === [$relatedBook->id_buku]);
    }

    public function test_admin_dashboard_user_and_settings_pages_render(): void
    {
        $this->createRole(1, 'admin');
        $admin = User::create([
            'username' => 'admin',
            'password' => 'password123',
            'nama' => 'Admin Contoh',
            'id_role' => 1,
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk();
        $this->get(route('users.index'))->assertOk();
        $this->get(route('users.create'))->assertOk();
        $this->get(route('settings.index'))->assertOk();
    }

    public function test_inactive_users_cannot_log_in(): void
    {
        $this->createRole(2, 'petugas');
        User::create([
            'username' => 'petugas-nonaktif',
            'password' => Hash::make('password123'),
            'nama' => 'Petugas Nonaktif',
            'id_role' => 2,
            'status' => 'nonaktif',
        ]);

        $this->post(route('login.action'), [
            'username' => 'petugas-nonaktif',
            'password' => 'password123',
        ])->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_database_seeders_can_be_run_more_than_once_without_duplicates(): void
    {
        $this->seed();
        $tables = ['roles', 'users', 'anggotas', 'kategoris', 'bukus', 'settings'];
        $firstCounts = collect($tables)->mapWithKeys(
            fn ($table) => [$table => DB::table($table)->count()]
        );
        $adminPassword = User::where('username', 'admin')->value('password');

        $this->seed();

        $secondCounts = collect($tables)->mapWithKeys(
            fn ($table) => [$table => DB::table($table)->count()]
        );
        $this->assertSame($firstCounts->all(), $secondCounts->all());
        $this->assertSame($adminPassword, User::where('username', 'admin')->value('password'));
    }

    public function test_role_migration_deduplicates_names_and_preserves_user_role_links(): void
    {
        $this->createRole(1, 'admin');
        $duplicateRoleId = DB::table('roles')->insertGetId([
            'nama_role' => 'Admin',
            'deskripsi' => 'Duplicate role',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'username' => 'duplicate-role-user',
            'password' => Hash::make('password123'),
            'nama' => 'Test User',
            'id_role' => $duplicateRoleId,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('roles', function ($table) {
            $table->dropUnique(['nama_role']);
        });

        $migration = require database_path('migrations/2026_11_07_000002_deduplicate_roles_and_enforce_unique_names.php');
        $migration->up();

        $canonicalRoleId = DB::table('roles')->where('nama_role', 'admin')->value('id_role');
        $this->assertSame(1, DB::table('roles')->count());
        $this->assertSame(
            $canonicalRoleId,
            DB::table('users')->where('username', 'duplicate-role-user')->value('id_role')
        );
        $this->assertSame(1, DB::table('roles')->where('nama_role', 'admin')->count());
    }

    public function test_overdue_loan_is_shown_on_dashboard_and_records_a_fine_on_return(): void
    {
        $this->travelTo(now()->startOfDay());
        $this->createRole(2, 'petugas');
        $petugas = User::create([
            'username' => 'petugas-terlambat',
            'password' => 'password123',
            'nama' => 'Petugas Contoh',
            'id_role' => 2,
            'status' => 'aktif',
        ]);
        $kategori = Kategori::create(['nama_kategori' => 'Fiksi']);
        $anggota = Anggota::create([
            'nis' => '2026003',
            'nomor_induk' => '2026003',
            'nama' => 'Anggota Terlambat',
            'kelas' => 'X PPLG 1',
            'no_hp' => '081234567890',
            'status' => 'aktif',
        ]);
        $buku = Buku::create([
            'judul' => 'Buku Terlambat',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun_penerbit' => 2025,
            'id_kategori' => $kategori->id_kategori,
            'stok' => 1,
            'status' => 'tersedia',
            'isbn' => 'TEST-ISBN-LATE',
        ]);

        $this->actingAs($petugas)->post(route('peminjaman.store'), [
            'id_anggota' => $anggota->id_anggota,
            'id_buku' => $buku->id_buku,
            'tanggal_pinjam' => today()->subDays(10)->toDateString(),
            'tanggal_kembali' => today()->subDays(3)->toDateString(),
        ])->assertRedirect(route('dashboard.petugas'));

        $this->get(route('dashboard.petugas'))
            ->assertOk()
            ->assertSee('Perlu Pengingat')
            ->assertSee('Buku Terlambat');

        $peminjamanId = DB::table('peminjamen')->value('id_peminjaman');
        $this->post(route('pengembalian.proses'), ['id_peminjaman' => $peminjamanId])
            ->assertRedirect(route('dashboard.petugas'));

        $this->assertDatabaseHas('pengembalians', [
            'id_peminjaman' => $peminjamanId,
            'denda' => 3000,
            'status_pengembalian' => 'belum_lunas',
        ]);
        $this->assertDatabaseHas('bukus', ['id_buku' => $buku->id_buku, 'stok' => 1]);
    }

    private function createRole(int $id, string $name): void
    {
        DB::table('roles')->insert([
            'id_role' => $id,
            'nama_role' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
