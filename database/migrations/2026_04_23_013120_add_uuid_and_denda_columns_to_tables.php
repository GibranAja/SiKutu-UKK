<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Alter Peminjamans
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id_peminjaman');
        });
        
        DB::statement("UPDATE peminjamans SET uuid = UUID() WHERE uuid IS NULL");
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN uuid CHAR(36) NOT NULL UNIQUE");
        
        // Remove foreign key temporarily to alter column
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['id_admin_pinjam']);
        });
        
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN id_admin_pinjam bigint unsigned NULL");
        
        // Add foreign key back
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->foreign('id_admin_pinjam')->references('id_admin')->on('admins')->onDelete('restrict')->onUpdate('cascade');
        });
        
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status_peminjaman ENUM('MENUNGGU_KONFIRMASI', 'DIPINJAM', 'DIKEMBALIKAN', 'DITOLAK', 'HILANG', 'RUSAK') DEFAULT 'MENUNGGU_KONFIRMASI'");

        // Alter Pengembalians
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id_pengembalian');
            $table->enum('metode_pembayaran', ['TUNAI', 'TRANSFER'])->nullable()->after('status_denda');
            $table->longText('bukti_pembayaran')->nullable()->after('metode_pembayaran');
        });
        
        DB::statement("UPDATE pengembalians SET uuid = UUID() WHERE uuid IS NULL");
        DB::statement("ALTER TABLE pengembalians MODIFY COLUMN uuid CHAR(36) NOT NULL UNIQUE");
        DB::statement("ALTER TABLE pengembalians MODIFY COLUMN status_denda ENUM('TIDAK_ADA', 'LUNAS', 'BELUM_LUNAS', 'MENUNGGU_KONFIRMASI') DEFAULT 'TIDAK_ADA'");

        // Alter Bukus
        Schema::table('bukus', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id_buku');
        });
        DB::statement("UPDATE bukus SET uuid = UUID() WHERE uuid IS NULL");
        DB::statement("ALTER TABLE bukus MODIFY COLUMN uuid CHAR(36) NOT NULL UNIQUE");

        // Alter Anggota
        Schema::table('anggota_perpustakaan', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id_anggota');
        });
        DB::statement("UPDATE anggota_perpustakaan SET uuid = UUID() WHERE uuid IS NULL");
        DB::statement("ALTER TABLE anggota_perpustakaan MODIFY COLUMN uuid CHAR(36) NOT NULL UNIQUE");

        // Alter Admins
        Schema::table('admins', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id_admin');
        });
        DB::statement("UPDATE admins SET uuid = UUID() WHERE uuid IS NULL");
        DB::statement("ALTER TABLE admins MODIFY COLUMN uuid CHAR(36) NOT NULL UNIQUE");

        // Alter Genres
        Schema::table('genres', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id_genre');
        });
        DB::statement("UPDATE genres SET uuid = UUID() WHERE uuid IS NULL");
        DB::statement("ALTER TABLE genres MODIFY COLUMN uuid CHAR(36) NOT NULL UNIQUE");
    }

    public function down(): void
    {
        // Revert down is complex due to raw statements, we will drop columns
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status_peminjaman ENUM('DIPINJAM', 'DIKEMBALIKAN') DEFAULT 'DIPINJAM'");
        
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->dropColumn('metode_pembayaran');
            $table->dropColumn('bukti_pembayaran');
        });
        DB::statement("ALTER TABLE pengembalians MODIFY COLUMN status_denda ENUM('TIDAK_ADA', 'LUNAS', 'BELUM_LUNAS') DEFAULT 'TIDAK_ADA'");

        Schema::table('bukus', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('anggota_perpustakaan', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('genres', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
