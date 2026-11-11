@extends('layouts.publik')
@section('title', '500 - Terjadi Kendala Sistem')
@section('content')
<div class="container text-center py-5">
    <h1 class="display-1 fw-bold text-warning">500</h1>
    <h2 class="mb-3">Terjadi Kendala Sistem</h2>
    <p class="text-muted mb-4">Maaf, terjadi kesalahan pada server kami. Tim teknis telah menerima laporan ini.</p>
    <a href="{{ route('publik.beranda') }}" class="btn btn-warning px-4 py-2">Kembali ke Beranda</a>
</div>
@endsection