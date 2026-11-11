<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id('id_pengembalian');
            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('id_user');
            $table->date('tgl_pengembalian');
            $table->decimal('denda', 10, 2)->default(0);
            $table->enum('status_pengembalian', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->timestamps();

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjamen')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};