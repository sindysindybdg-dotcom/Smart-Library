@extends('layouts.publik')
@section('title', '403 - Akses Ditolak')
@section('content')
<div class="container text-center py-5">
    <h1 class="display-1 fw-bold text-danger">403</h1>
    <h2 class="mb-3">Akses Ditolak</h2>
    <p class="text-muted mb-4">Anda tidak memiliki izin untuk mengakses halaman ini. Silakan login dengan akun yang sesuai.</p>
    <a href="{{ route('login') }}" class="btn btn-danger px-4 py-2">Login Sekarang</a>
</div>
@endsection