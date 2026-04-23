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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('kode_buku', 50)->unique();
            $table->string('judul_buku', 255);
            $table->string('pengarang', 150);
            $table->string('penerbit', 150)->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('jenis_buku', 50)->nullable()->comment('Jenis/tipe buku: Fiksi, Non-Fiksi, dll');
            $table->integer('stok')->default(0);
            $table->enum('kondisi', ['BAIK', 'RUSAK', 'HILANG'])->default('BAIK');
            $table->string('gambar_cover', 255)->nullable();
            $table->enum('status_buku', ['TERSEDIA', 'DIPINJAM', 'TIDAK_TERSEDIA'])->default('TERSEDIA');
            $table->timestamps();

            // Indexes
            $table->index('jenis_buku', 'idx_buku_jenis');
            $table->index('status_buku', 'idx_buku_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
