<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $roles = DB::table('roles')->orderBy('id_role')->get();
            $groups = $roles->groupBy(fn ($role) => mb_strtolower(trim($role->nama_role)));

            foreach ($groups as $name => $duplicates) {
                if ($name === '') {
                    throw new RuntimeException('Role dengan nama kosong tidak dapat dinormalisasi otomatis.');
                }

                $canonical = $duplicates->first();
                DB::table('roles')
                    ->where('id_role', $canonical->id_role)
                    ->update(['nama_role' => $name]);

                foreach ($duplicates->skip(1) as $duplicate) {
                    DB::table('users')
                        ->where('id_role', $duplicate->id_role)
                        ->update(['id_role' => $canonical->id_role]);
                    DB::table('roles')->where('id_role', $duplicate->id_role)->delete();
                }
            }
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->unique('nama_role');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique(['nama_role']);
        });
    }
};
