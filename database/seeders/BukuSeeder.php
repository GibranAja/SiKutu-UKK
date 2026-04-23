<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Genre;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $bukus = [
            ['kode_buku' => 'BK-001', 'judul_buku' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'jenis_buku' => 'Fiksi', 'stok' => 5, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-002', 'judul_buku' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun_terbit' => 1980, 'jenis_buku' => 'Fiksi', 'stok' => 3, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-003', 'judul_buku' => 'Fisika Dasar', 'pengarang' => 'Halliday & Resnick', 'penerbit' => 'Erlangga', 'tahun_terbit' => 2010, 'jenis_buku' => 'Non-Fiksi', 'stok' => 10, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-004', 'judul_buku' => 'Matematika Kelas 10', 'pengarang' => 'Tim Kemendikbud', 'penerbit' => 'Kemendikbud', 'tahun_terbit' => 2022, 'jenis_buku' => 'Non-Fiksi', 'stok' => 15, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-005', 'judul_buku' => 'Pemrograman Web dengan Laravel', 'pengarang' => 'Rahmat Hidayat', 'penerbit' => 'Informatika', 'tahun_terbit' => 2023, 'jenis_buku' => 'Non-Fiksi', 'stok' => 4, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-006', 'judul_buku' => 'Sejarah Indonesia', 'pengarang' => 'Tim Penulis', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2020, 'jenis_buku' => 'Non-Fiksi', 'stok' => 7, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-007', 'judul_buku' => 'Dilan 1990', 'pengarang' => 'Pidi Baiq', 'penerbit' => 'Pastel Books', 'tahun_terbit' => 2014, 'jenis_buku' => 'Fiksi', 'stok' => 6, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-008', 'judul_buku' => 'Algoritma dan Pemrograman', 'pengarang' => 'Rinaldi Munir', 'penerbit' => 'Informatika', 'tahun_terbit' => 2016, 'jenis_buku' => 'Non-Fiksi', 'stok' => 8, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-009', 'judul_buku' => 'Bahasa Inggris Kelas 11', 'pengarang' => 'Tim Kemendikbud', 'penerbit' => 'Kemendikbud', 'tahun_terbit' => 2022, 'jenis_buku' => 'Non-Fiksi', 'stok' => 12, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
            ['kode_buku' => 'BK-010', 'judul_buku' => 'Negeri 5 Menara', 'pengarang' => 'Ahmad Fuadi', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2009, 'jenis_buku' => 'Fiksi', 'stok' => 4, 'kondisi' => 'BAIK', 'status_buku' => 'TERSEDIA'],
        ];

        $genreMap = [
            'Fiksi' => Genre::where('nama_genre', 'Fiksi')->first()?->id_genre,
            'Non-Fiksi' => Genre::where('nama_genre', 'Non-Fiksi')->first()?->id_genre,
            'Novel' => Genre::where('nama_genre', 'Novel')->first()?->id_genre,
            'Teknologi' => Genre::where('nama_genre', 'Teknologi')->first()?->id_genre,
            'Sejarah' => Genre::where('nama_genre', 'Sejarah')->first()?->id_genre,
            'Pendidikan' => Genre::where('nama_genre', 'Pendidikan')->first()?->id_genre,
            'Bahasa' => Genre::where('nama_genre', 'Bahasa')->first()?->id_genre,
            'Matematika' => Genre::where('nama_genre', 'Matematika')->first()?->id_genre,
            'Sains' => Genre::where('nama_genre', 'Sains')->first()?->id_genre,
        ];

        // Genre mapping for each book
        $bukuGenres = [
            'BK-001' => ['Fiksi', 'Novel'],
            'BK-002' => ['Fiksi', 'Novel', 'Sejarah'],
            'BK-003' => ['Non-Fiksi', 'Sains', 'Pendidikan'],
            'BK-004' => ['Non-Fiksi', 'Matematika', 'Pendidikan'],
            'BK-005' => ['Non-Fiksi', 'Teknologi', 'Pendidikan'],
            'BK-006' => ['Non-Fiksi', 'Sejarah', 'Pendidikan'],
            'BK-007' => ['Fiksi', 'Novel'],
            'BK-008' => ['Non-Fiksi', 'Teknologi', 'Pendidikan'],
            'BK-009' => ['Non-Fiksi', 'Bahasa', 'Pendidikan'],
            'BK-010' => ['Fiksi', 'Novel'],
        ];

        foreach ($bukus as $bukuData) {
            $buku = Buku::create($bukuData);
            $kode = $bukuData['kode_buku'];
            if (isset($bukuGenres[$kode])) {
                $genreIds = collect($bukuGenres[$kode])
                    ->map(fn($name) => $genreMap[$name] ?? null)
                    ->filter()
                    ->toArray();
                $buku->genres()->attach($genreIds);
            }
        }
    }
}
