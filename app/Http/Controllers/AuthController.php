<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\AnggotaPerpustakaan;
use App\Models\LogAktivitas;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login — mendukung login admin dan anggota.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,siswa',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.required'     => 'Pilih role login Anda.',
            'role.in'           => 'Role tidak valid.',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $role     = $request->input('role');

        if ($role === 'admin') {
            return $this->loginAdmin($request, $username, $password);
        }

        return $this->loginAnggota($request, $username, $password);
    }

    /**
     * Proses login admin.
     */
    private function loginAdmin(Request $request, string $username, string $password)
    {
        $credentials = [
            'username' => $username,
            'password' => $password,
        ];

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Log aktivitas login admin
            LogAktivitas::catat(
                Auth::guard('admin')->id(),
                'LOGIN',
                'auth',
                'Admin berhasil login'
            );

            return redirect()->intended(route('admin.dashboard'))
                             ->with('success', 'Selamat datang, ' . Auth::guard('admin')->user()->nama_lengkap . '!');
        }

        return back()->withErrors([
            'login' => 'Username atau password admin salah.',
        ])->withInput($request->only('username', 'role'));
    }

    /**
     * Proses login anggota/siswa.
     */
    private function loginAnggota(Request $request, string $username, string $password)
    {
        // Cari anggota berdasarkan username terlebih dahulu untuk validasi status
        $anggota = AnggotaPerpustakaan::where('username', $username)->first();

        if (!$anggota) {
            return back()->withErrors([
                'login' => 'Username atau password salah.',
            ])->withInput($request->only('username', 'role'));
        }

        // Cek status anggota sebelum login
        if ($anggota->status_anggota === 'NONAKTIF') {
            return back()->withErrors([
                'login' => 'Akun Anda telah dinonaktifkan. Hubungi admin perpustakaan.',
            ])->withInput($request->only('username', 'role'));
        }

        if ($anggota->status_anggota === 'DIBLOKIR') {
            return back()->withErrors([
                'login' => 'Akun Anda telah diblokir. Hubungi admin perpustakaan.',
            ])->withInput($request->only('username', 'role'));
        }

        // Cek masa berlaku
        if (!$anggota->isMasihBerlaku()) {
            return back()->withErrors([
                'login' => 'Kartu anggota Anda sudah kedaluwarsa. Hubungi admin untuk perpanjangan.',
            ])->withInput($request->only('username', 'role'));
        }

        $credentials = [
            'username' => $username,
            'password' => $password,
        ];

        if (Auth::guard('anggota')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('siswa.dashboard'))
                             ->with('success', 'Selamat datang, ' . Auth::guard('anggota')->user()->nama_lengkap . '!');
        }

        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->withInput($request->only('username', 'role'));
    }

    /**
     * Proses logout (admin maupun anggota).
     */
    public function logout(Request $request)
    {
        // Log aktivitas logout admin
        if (Auth::guard('admin')->check()) {
            LogAktivitas::catat(
                Auth::guard('admin')->id(),
                'LOGOUT',
                'auth',
                'Admin berhasil logout'
            );
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('anggota')->check()) {
            Auth::guard('anggota')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
