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
        Schema::create('buku_genre', function (Blueprint $table) {
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_genre');

            // Composite primary key
            $table->primary(['id_buku', 'id_genre'], 'pk_buku_genre');

            // Foreign keys
            $table->foreign('id_buku')
                  ->references('id_buku')
                  ->on('bukus')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_genre')
                  ->references('id_genre')
                  ->on('genres')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Index
            $table->index('id_genre', 'idx_buku_genre_genre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_genre');
    }
};
