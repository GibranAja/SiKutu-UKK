<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE pengembalians MODIFY COLUMN status_denda ENUM('LUNAS', 'BELUM_LUNAS', 'TIDAK_ADA', 'MENUNGGU_KONFIRMASI', 'DITOLAK') DEFAULT 'TIDAK_ADA'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pengembalians MODIFY COLUMN status_denda ENUM('LUNAS', 'BELUM_LUNAS', 'TIDAK_ADA') DEFAULT 'TIDAK_ADA'");
    }
};
