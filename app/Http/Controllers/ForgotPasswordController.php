<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\AnggotaPerpustakaan;
use App\Models\PasswordReset;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan halaman lupa password — langkah 1: input username.
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Proses permintaan reset password — generate token.
     * Karena sistem berjalan di localhost (tanpa internet/email),
     * token ditampilkan langsung kepada admin untuk diberikan ke user.
     */
    public function requestReset(Request $request)
    {
        $request->validate([
            'identifier'  => 'required|string|max:100',
        ], [
            'identifier.required'  => 'Username atau email wajib diisi.',
        ]);

        $identifier = $request->input('identifier');

        // Verifikasi user ada
        $admin = Admin::where('username', $identifier)->first();
        $anggota = AnggotaPerpustakaan::where('username', $identifier)->orWhere('email', $identifier)->first();

        if ($admin) {
            $user = $admin;
            $tipeUser = 'admin';
            $username = $admin->username;
        } elseif ($anggota) {
            $user = $anggota;
            $tipeUser = 'anggota';
            $username = $anggota->username;
        } else {
            return back()->withErrors([
                'identifier' => 'Akun tidak ditemukan.',
            ])->withInput();
        }

        // Invalidate token lama yang belum digunakan
        PasswordReset::where('username', $username)
                     ->where('tipe_user', $tipeUser)
                     ->where('is_used', false)
                     ->update(['is_used' => true]);

        // Generate token baru
        $token = strtoupper(Str::random(8)); // Token pendek, mudah diingat

        PasswordReset::create([
            'username'   => $username,
            'token'      => Hash::make($token),
            'tipe_user'  => $tipeUser,
            'is_used'    => false,
            'expired_at' => Carbon::now()->addHours(1),
            'created_at' => Carbon::now(),
        ]);

        // Karena localhost tanpa email, tampilkan token di halaman
        // Dalam skenario nyata, token ini diberikan admin ke siswa secara langsung
        return redirect()->route('password.reset.form', ['token_display' => $token, 'username' => $username, 'tipe' => $tipeUser])
                         ->with('reset_token', $token)
                         ->with('success', 'Token reset password berhasil dibuat. Gunakan token berikut untuk mereset password Anda.');
    }

    /**
     * Tampilkan halaman reset password — langkah 2: input token & password baru.
     */
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', [
            'token'    => $request->query('token_display', ''),
            'username' => $request->query('username', ''),
            'tipe'     => $request->query('tipe', ''),
        ]);
    }

    /**
     * Proses reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'username'     => 'required|string|max:50',
            'token'        => 'required|string',
            'tipe_user'    => 'required|in:admin,anggota',
            'password'     => 'required|string|min:6|confirmed',
        ], [
            'username.required' => 'Username wajib diisi.',
            'token.required'    => 'Token reset wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $username = $request->input('username');
        $token    = $request->input('token');
        $tipeUser = $request->input('tipe_user');

        // Cari token reset yang masih valid
        $resetRecords = PasswordReset::where('username', $username)
                                     ->where('tipe_user', $tipeUser)
                                     ->where('is_used', false)
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        $validReset = null;
        foreach ($resetRecords as $record) {
            if (Hash::check($token, $record->token) && $record->expired_at->isFuture()) {
                $validReset = $record;
                break;
            }
        }

        if (!$validReset) {
            return back()->withErrors([
                'token' => 'Token tidak valid atau sudah kedaluwarsa.',
            ])->withInput($request->only('username', 'tipe_user'));
        }

        // Update password user
        if ($tipeUser === 'admin') {
            $user = Admin::where('username', $username)->first();
        } else {
            $user = AnggotaPerpustakaan::where('username', $username)->first();
        }

        if (!$user) {
            return back()->withErrors([
                'username' => 'User tidak ditemukan.',
            ])->withInput();
        }

        $user->update([
            'password' => $request->input('password'),
        ]);

        // Mark token as used
        $validReset->markAsUsed();

        return redirect()->route('login')
                         ->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
