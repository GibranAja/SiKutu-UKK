<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'username'      => 'admin',
            'password'      => 'admin123',
            'nama_lengkap'  => 'Administrator Perpustakaan',
            'email'         => 'admin@sikutu.local',
            'photo_profile' => null,
        ]);
    }
}
