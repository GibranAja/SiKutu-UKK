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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id('id_pengembalian');
            $table->unsignedBigInteger('id_peminjaman')->unique();
            $table->date('tanggal_kembali')->default(now()->toDateString());
            $table->enum('kondisi_buku_kembali', ['BAIK', 'RUSAK'])->default('BAIK');
            $table->decimal('denda_keterlambatan', 10, 2)->default(0.00)->comment('Denda otomatis dari keterlambatan');
            $table->decimal('denda_kondisi', 10, 2)->default(0.00)->comment('Denda manual dari kondisi buku rusak');
            $table->decimal('denda_total', 10, 2)->default(0.00)->comment('Total semua denda');
            $table->enum('status_denda', ['LUNAS', 'BELUM_LUNAS', 'TIDAK_ADA'])->default('TIDAK_ADA');
            $table->unsignedBigInteger('id_petugas_kembali');
            $table->text('catatan_petugas')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_peminjaman')
                  ->references('id_peminjaman')
                  ->on('peminjamans')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_petugas_kembali')
                  ->references('id_admin')
                  ->on('admins')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // Indexes
            $table->index('id_petugas_kembali', 'idx_pengembalian_petugas');
            $table->index('tanggal_kembali', 'idx_pengembalian_tgl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
