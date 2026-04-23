<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->unsignedBigInteger('id_anggota');
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_admin_pinjam');
            $table->date('tanggal_pinjam')->default(now()->toDateString());
            $table->date('tanggal_harus_kembali');
            $table->enum('status_peminjaman', ['DIPINJAM', 'DIKEMBALIKAN'])->default('DIPINJAM');
            $table->text('catatan_peminjaman')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_anggota')
                  ->references('id_anggota')
                  ->on('anggota_perpustakaan')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('id_buku')
                  ->references('id_buku')
                  ->on('bukus')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('id_admin_pinjam')
                  ->references('id_admin')
                  ->on('admins')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // Indexes
            $table->index('id_anggota', 'idx_peminjaman_anggota');
            $table->index('id_buku', 'idx_peminjaman_buku');
            $table->index('id_admin_pinjam', 'idx_peminjaman_admin');
            $table->index('status_peminjaman', 'idx_peminjaman_status');
            $table->index(['id_anggota', 'id_buku', 'tanggal_pinjam'], 'idx_peminjaman_composite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
