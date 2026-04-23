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
        Schema::create('pengaturan_denda', function (Blueprint $table) {
            $table->id('id_pengaturan');
            $table->decimal('denda_per_hari', 10, 2)->default(1000.00)->comment('Nominal denda per hari keterlambatan (Rupiah)');
            $table->integer('maks_hari_pinjam')->default(7)->comment('Maksimal hari peminjaman');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('updated_by')
                  ->references('id_admin')
                  ->on('admins')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_denda');
    }
};
