<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanDenda;

class PengaturanDendaSeeder extends Seeder
{
    public function run(): void
    {
        PengaturanDenda::create([
            'denda_per_hari'   => 1000.00,
            'maks_hari_pinjam' => 7,
            'is_active'        => true,
            'updated_by'       => 1, // Admin default
        ]);
    }
}
