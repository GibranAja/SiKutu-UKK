<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Urutan seeder penting karena ada dependensi foreign key:
     * 1. AdminSeeder (admins harus ada dulu)
     * 2. GenreSeeder (genres harus ada sebelum buku)
     * 3. BukuSeeder (butuh genre)
     * 4. AnggotaSeeder (butuh admin sebagai pendaftar)
     * 5. PengaturanDendaSeeder (butuh admin)
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            GenreSeeder::class,
            BukuSeeder::class,
            AnggotaSeeder::class,
            PengaturanDendaSeeder::class,
        ]);
    }
}
