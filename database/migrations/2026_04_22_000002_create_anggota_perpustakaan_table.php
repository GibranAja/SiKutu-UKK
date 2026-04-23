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
        Schema::create('anggota_perpustakaan', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('nama_lengkap', 100);
            $table->string('nis', 20)->unique();
            $table->string('kelas', 2)->comment('Enum: 10 | 11 | 12');
            $table->string('jurusan', 20)->comment('Jurusan siswa: PPLG, BCF, ANM, TO, TPFL');
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('photo_profile', 255)->nullable();
            $table->enum('status_anggota', ['AKTIF', 'NONAKTIF', 'DIBLOKIR'])->default('AKTIF');
            $table->date('tanggal_daftar')->default(now()->toDateString());
            $table->date('masa_berlaku');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Foreign key
            $table->foreign('id_admin')
                  ->references('id_admin')
                  ->on('admins')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // Indexes
            $table->index('id_admin', 'idx_anggota_admin');
            $table->index('status_anggota', 'idx_anggota_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_perpustakaan');
    }
};
