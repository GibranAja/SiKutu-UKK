<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['nama_genre' => 'Fiksi', 'deskripsi' => 'Buku cerita rekaan/fiksi'],
            ['nama_genre' => 'Non-Fiksi', 'deskripsi' => 'Buku berdasarkan fakta'],
            ['nama_genre' => 'Sains', 'deskripsi' => 'Buku ilmu pengetahuan alam'],
            ['nama_genre' => 'Teknologi', 'deskripsi' => 'Buku tentang teknologi dan komputer'],
            ['nama_genre' => 'Sejarah', 'deskripsi' => 'Buku tentang sejarah'],
            ['nama_genre' => 'Matematika', 'deskripsi' => 'Buku pelajaran matematika'],
            ['nama_genre' => 'Bahasa', 'deskripsi' => 'Buku bahasa Indonesia dan asing'],
            ['nama_genre' => 'Agama', 'deskripsi' => 'Buku tentang agama dan spiritual'],
            ['nama_genre' => 'Seni & Budaya', 'deskripsi' => 'Buku tentang seni dan kebudayaan'],
            ['nama_genre' => 'Olahraga', 'deskripsi' => 'Buku tentang olahraga dan kesehatan'],
            ['nama_genre' => 'Biografi', 'deskripsi' => 'Buku biografi tokoh terkenal'],
            ['nama_genre' => 'Ensiklopedia', 'deskripsi' => 'Buku referensi dan ensiklopedia'],
            ['nama_genre' => 'Novel', 'deskripsi' => 'Novel fiksi dan sastra'],
            ['nama_genre' => 'Komik', 'deskripsi' => 'Komik dan manga'],
            ['nama_genre' => 'Pendidikan', 'deskripsi' => 'Buku pelajaran sekolah'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}
