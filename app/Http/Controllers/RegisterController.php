<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AnggotaPerpustakaan;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman register (hanya untuk siswa).
     */
    public function showRegister()
    {
        $jurusanList = AnggotaPerpustakaan::getAllJurusan();
        return view('auth.register', compact('jurusanList'));
    }

    /**
     * Proses registrasi anggota baru.
     */
    public function register(Request $request)
    {
        $jurusanValid = ['PPLG', 'BCF', 'ANM', 'TO', 'TPFL'];

        $request->validate([
            'username'      => 'required|string|max:50|unique:anggota_perpustakaan,username|alpha_dash',
            'password'      => 'required|string|min:6|confirmed',
            'nama_lengkap'  => 'required|string|max:100',
            'nis'           => 'required|string|max:20|unique:anggota_perpustakaan,nis',
            'tingkat'       => 'required|in:10,11,12',
            'jurusan_base'  => 'required|in:' . implode(',', $jurusanValid),
            'rombel'        => 'required|integer|min:1|max:3',
            'alamat'        => 'nullable|string|max:500',
            'no_telepon'    => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:100|unique:anggota_perpustakaan,email',
        ], [
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan.',
            'username.alpha_dash'   => 'Username hanya boleh berisi huruf, angka, dash, dan underscore.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nis.required'          => 'NIS wajib diisi.',
            'nis.unique'            => 'NIS sudah terdaftar.',
            'tingkat.required'      => 'Kelas wajib dipilih.',
            'tingkat.in'            => 'Kelas tidak valid.',
            'jurusan_base.required' => 'Jurusan wajib dipilih.',
            'jurusan_base.in'       => 'Jurusan tidak valid.',
            'rombel.required'       => 'Rombel wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan.',
        ]);

        $anggota = AnggotaPerpustakaan::create([
            'username'       => $request->input('username'),
            'password'       => $request->input('password'),
            'nama_lengkap'   => $request->input('nama_lengkap'),
            'nis'            => $request->input('nis'),
            'kelas'          => $request->input('tingkat'),
            'jurusan'        => $request->input('jurusan_base') . ' ' . $request->input('rombel'),
            'alamat'         => $request->input('alamat'),
            'no_telepon'     => $request->input('no_telepon'),
            'email'          => $request->input('email'),
            'status_anggota' => 'AKTIF',
            'tanggal_daftar' => Carbon::now()->toDateString(),
            'masa_berlaku'   => Carbon::now()->addYear()->toDateString(), // Berlaku 1 tahun
            'id_admin'       => null, // Self-registration, tidak ada admin yang mendaftarkan
        ]);

        return redirect()->route('login')
                         ->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }
}
