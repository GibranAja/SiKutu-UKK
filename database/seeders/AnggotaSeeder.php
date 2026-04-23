<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnggotaPerpustakaan;
use Carbon\Carbon;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $anggotas = [
            ['username' => 'siswa1', 'password' => 'siswa123', 'nama_lengkap' => 'Ahmad Fauzi', 'nis' => '2024001', 'kelas' => '10', 'jurusan' => '10 PPLG 1', 'alamat' => 'Jl. Merdeka No. 1', 'no_telepon' => '081234567890', 'email' => 'ahmad@sikutu.local'],
            ['username' => 'siswa2', 'password' => 'siswa123', 'nama_lengkap' => 'Siti Nurhaliza', 'nis' => '2024002', 'kelas' => '10', 'jurusan' => '10 PPLG 2', 'alamat' => 'Jl. Sudirman No. 5', 'no_telepon' => '081234567891', 'email' => 'siti@sikutu.local'],
            ['username' => 'siswa3', 'password' => 'siswa123', 'nama_lengkap' => 'Budi Santoso', 'nis' => '2024003', 'kelas' => '11', 'jurusan' => '11 BCF 1', 'alamat' => 'Jl. Gatot Subroto No. 10', 'no_telepon' => '081234567892', 'email' => 'budi@sikutu.local'],
            ['username' => 'siswa4', 'password' => 'siswa123', 'nama_lengkap' => 'Dewi Lestari', 'nis' => '2024004', 'kelas' => '12', 'jurusan' => '12 ANM 1', 'alamat' => 'Jl. Ahmad Yani No. 15', 'no_telepon' => '081234567893', 'email' => 'dewi@sikutu.local'],
            ['username' => 'siswa5', 'password' => 'siswa123', 'nama_lengkap' => 'Rizky Pratama', 'nis' => '2024005', 'kelas' => '11', 'jurusan' => '11 TO 1', 'alamat' => 'Jl. Diponegoro No. 20', 'no_telepon' => '081234567894', 'email' => 'rizky@sikutu.local'],
        ];

        foreach ($anggotas as $data) {
            AnggotaPerpustakaan::create(array_merge($data, [
                'status_anggota' => 'AKTIF',
                'tanggal_daftar' => Carbon::now()->toDateString(),
                'masa_berlaku'   => Carbon::now()->addYear()->toDateString(),
                'id_admin'       => 1,
            ]));
        }
    }
}
