<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->string('nama', 100);
            $table->unsignedBigInteger('id_role');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamp('last_login')->nullable();
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};