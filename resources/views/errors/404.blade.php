@extends('layouts.publik')
@section('title', '404 - Halaman Tidak Ditemukan')
@section('content')
<div class="container text-center py-5">
    <h1 class="display-1 fw-bold text-primary">404</h1>
    <h2 class="mb-3">Oops! Halaman Tidak Ditemukan</h2>
    <p class="text-muted mb-4">Halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau tidak pernah ada.</p>
    <a href="{{ route('publik.beranda') }}" class="btn btn-primary px-4 py-2">Kembali ke Beranda</a>
</div>
@endsection