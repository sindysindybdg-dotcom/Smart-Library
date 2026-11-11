<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('judul', 200);
            $table->string('penulis', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_penerbit');
            $table->unsignedBigInteger('id_kategori');
            $table->integer('stok')->default(0);
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};