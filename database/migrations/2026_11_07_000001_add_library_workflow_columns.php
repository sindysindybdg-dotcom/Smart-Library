<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->string('nomor_induk', 20)->nullable()->unique();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('jenis_kelamin', 1)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('tipe', 20)->nullable();
        });

        DB::table('anggotas')->whereNull('nomor_induk')->update([
            'nomor_induk' => DB::raw('nis'),
            'no_hp' => DB::raw('no_telepon'),
            'whatsapp' => DB::raw('no_telepon'),
        ]);

        Schema::table('bukus', function (Blueprint $table) {
            $table->string('isbn', 50)->nullable()->unique();
            $table->string('cover')->nullable();
            $table->string('lokasi_rak', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropUnique(['isbn']);
            $table->dropColumn(['isbn', 'cover', 'lokasi_rak']);
        });

        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id']);
            $table->dropUnique(['nomor_induk']);
            $table->dropUnique(['email']);
            $table->dropColumn(['nomor_induk', 'user_id', 'jenis_kelamin', 'no_hp', 'whatsapp', 'email', 'tipe']);
        });
    }
};
