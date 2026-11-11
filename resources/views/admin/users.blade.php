@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="{{ route('dashboard') }}">Admin Perpustakaan</a>
    <span class="separator"><i class="bi bi-chevron-right"></i></span>
    <span style="color: var(--primary-blue); font-weight: 600;">Kelola Pengguna</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h2>Manajemen Pengguna & Hak Akses (RBAC)</h2>
        <p>Kelola akun autentikasi, pembagian peran, status aktif akun, dan audit keamanan sistem.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('users.export') }}" class="btn-outline-custom">
            <i class="bi bi-download"></i> Ekspor Data (CSV)
        </a>
        <a href="{{ route('users.create') }}" class="btn-primary-custom">
            <i class="bi bi-person-plus"></i> Tambah Pengguna
        </a>
    </div>
</div>

<!-- Alert Sukses -->
@if(session('success'))
<div class="info-card" style="background: #dcfce7; border-color: #86efac;">
    <div class="info-icon" style="background: #16a34a;"><i class="bi bi-check-circle"></i></div>
    <div class="info-content">
        <h5 style="color: #166534;">Berhasil!</h5>
        <p style="color: #166534; margin:0;">{{ session('success') }}</p>
    </div>
</div>
@endif

<!-- Info Card -->
<div class="info-card">
    <div class="info-icon"><i class="bi bi-shield-check"></i></div>
    <div class="info-content">
        <h5>Kebijakan Keamanan RBAC <span class="badge-custom badge-success">Bcrypt Active</span></h5>
        <p>Semua kredensial dienkripsi menggunakan Bcrypt. Rate-limiting login aktif. Administrator memiliki akses mutlak ke pengaturan sistem.</p>
    </div>
    <div class="info-right">
        <div>Zero-Trust Audit</div>
        <div class="status-ok">● Aman & Sinkron</div>
    </div>
</div>

<!-- Stat Cards (DINAMIS) -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-icon" style="background: #dbeafe; color: #2563eb;"><i class="bi bi-people"></i></div>
            </div>
            <div class="stat-value">{{ $users->total() }} <small>Akun</small></div>
            <div class="d-flex gap-2 mt-2 flex-wrap">
                <span class="badge-custom badge-info">{{ $roles->where('nama_role', 'admin')->count() }} Admin</span>
                <span class="badge-custom badge-purple">{{ $roles->where('nama_role', 'petugas')->count() }} Petugas</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Akun Aktif</div>
                <div class="stat-icon" style="background: #dcfce7; color: #16a34a;"><i class="bi bi-check-circle"></i></div>
            </div>
            <div class="stat-value">{{ $users->where('status', 'aktif')->count() }} <small>Akun</small></div>
            <div class="stat-footer">
                <span style="color: #10b981; font-weight: 600;"><i class="bi bi-arrow-up"></i> Sistem Normal</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Ditangguhkan / Nonaktif</div>
                <div class="stat-icon" style="background: #fef3c7; color: #d97706;"><i class="bi bi-pause-circle"></i></div>
            </div>
            <div class="stat-value">{{ $users->where('status', '!=', 'aktif')->count() }} <small>Akun</small></div>
            <div class="stat-footer">
                <span style="color: #dc2626; font-weight: 600;"><i class="bi bi-exclamation-triangle"></i> Perlu Verifikasi</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Sesi Login Hari Ini</div>
                <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;"><i class="bi bi-key"></i></div>
            </div>
            <div class="stat-value">{{ $users->where('last_login', '>=', now()->startOfDay())->count() }} <small>Sesi</small></div>
            <div class="stat-footer">
                <span style="color: #10b981; font-weight: 600;"><i class="bi bi-shield-check"></i> 0 Serangan</span>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar (FORM GET AGAR BERFUNGSI) -->
<div class="panel-card">
    <div class="panel-body" style="padding: 16px 20px;">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="d-flex gap-3 align-items-center flex-wrap">
                <div class="search-box" style="width: 280px;">
                    <i class="bi bi-search" style="color: var(--text-secondary);"></i>
                    <input type="text" name="search" placeholder="Cari nama atau username..." value="{{ request('search') }}">
                </div>
                <select name="role" class="form-select" style="width: auto; font-size: 13px;" onchange="this.form.submit()">
                    <option value="">Semua Peran</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id_role }}" {{ request('role') == $role->id_role ? 'selected' : '' }}>
                        {{ ucfirst($role->nama_role) }}
                    </option>
                    @endforeach
                </select>
                <select name="status" class="form-select" style="width: auto; font-size: 13px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <button type="submit" class="btn-outline-custom" style="padding: 8px 12px;">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('users.index') }}" class="btn-outline-custom" style="padding: 8px 12px;">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Users Table (DINAMIS FOREACH) -->
<div class="panel-card">
    <div class="panel-body" style="padding: 0; overflow-x: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox"></th>
                    <th style="width: 50px;">NO</th>
                    <th>PENGGUNA & PROFIL</th>
                    <th>PERAN (ROLE)</th>
                    <th>STATUS</th>
                    <th>TERAKHIR LOGIN</th>
                    <th style="width: 120px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td><input type="checkbox" name="users[]" value="{{ $user->id_user }}"></td>
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar-small" style="background: {{ ['#3b82f6', '#ec4899', '#10b981', '#8b5cf6', '#f59e0b'][$loop->index % 5] }}">
                                {{ strtoupper(substr($user->nama, 0, 2)) }}
                            </div>
                            <div class="user-details">
                                <strong>{{ $user->nama }} @if($user->id_role == 1) <i class="bi bi-patch-check-fill" style="color: var(--primary-blue);"></i> @endif</strong>
                                <small>{{ $user->username }}<br>ID: USR-{{ str_pad($user->id_user, 4, '0', STR_PAD_LEFT) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge {{ $user->role->nama_role == 'admin' ? 'role-admin' : ($user->role->nama_role == 'petugas' ? 'role-petugas' : 'role-anggota') }}">
                            {{ ucfirst($user->role->nama_role) }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge {{ $user->status == 'aktif' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td>
                        <div>{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->diffForHumans() : 'Belum pernah' }}</div>
                        <small style="color: var(--text-secondary);">IP: -</small>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-sm" style="background: #dbeafe; color: #2563eb;" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->nama }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626;" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 48px; color: var(--text-secondary);"></i>
                        <p class="text-muted mt-2">Tidak ada data pengguna yang ditemukan.</p>
                        <a href="{{ route('users.index') }}" class="btn-outline-custom btn-sm">Reset Filter</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination (DINAMIS) -->
    @if($users->hasPages())
    <div class="panel-body" style="padding: 16px 24px; border-top: 1px solid var(--border-color);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span style="font-size: 13px; color: var(--text-secondary);">
                Menampilkan <strong>{{ $users->firstItem() }}</strong> - <strong>{{ $users->lastItem() }}</strong> dari <strong>{{ $users->total() }}</strong> pengguna
            </span>
            <div class="pagination-custom">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection