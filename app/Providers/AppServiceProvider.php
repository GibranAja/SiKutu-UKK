<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE pengembalians MODIFY COLUMN status_denda ENUM('LUNAS', 'BELUM_LUNAS', 'TIDAK_ADA', 'MENUNGGU_KONFIRMASI', 'DITOLAK') DEFAULT 'TIDAK_ADA'");
            
            if (!\Illuminate\Support\Facades\Schema::hasColumn('bukus', 'deleted_at')) {
                \Illuminate\Support\Facades\Schema::table('bukus', function (\Illuminate\Database\Schema\Blueprint $table) { $table->softDeletes(); });
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('genres', 'deleted_at')) {
                \Illuminate\Support\Facades\Schema::table('genres', function (\Illuminate\Database\Schema\Blueprint $table) { $table->softDeletes(); });
            }
        } catch (\Exception $e) {
            // Abaikan jika sudah terubah atau jika tabel belum ada
        }
    }
}
