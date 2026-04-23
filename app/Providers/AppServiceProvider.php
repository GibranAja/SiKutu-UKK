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
        } catch (\Exception $e) {
            // Abaikan jika sudah terubah atau jika tabel belum ada
        }
    }
}
