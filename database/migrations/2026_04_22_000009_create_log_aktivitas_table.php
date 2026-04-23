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
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->string('aksi', 100)->comment('Contoh: CREATE_BUKU, DELETE_ANGGOTA, LOGIN, dll');
            $table->string('modul', 50)->comment('Modul yang diakses: buku, anggota, peminjaman, dll');
            $table->text('deskripsi')->nullable()->comment('Detail lengkap aktivitas');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('data_lama')->nullable()->comment('Snapshot data sebelum perubahan');
            $table->json('data_baru')->nullable()->comment('Snapshot data setelah perubahan');
            $table->timestamps();

            $table->foreign('id_admin')
                  ->references('id_admin')
                  ->on('admins')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->index('id_admin', 'idx_log_admin');
            $table->index('aksi', 'idx_log_aksi');
            $table->index('modul', 'idx_log_modul');
            $table->index('created_at', 'idx_log_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
