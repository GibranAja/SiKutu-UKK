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
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('token', 255);
            $table->enum('tipe_user', ['admin', 'anggota']);
            $table->boolean('is_used')->default(false);
            $table->timestamp('expired_at');
            $table->timestamp('created_at')->useCurrent();

            $table->index('username', 'idx_reset_username');
            $table->index('token', 'idx_reset_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};
