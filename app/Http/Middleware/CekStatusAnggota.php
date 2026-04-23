<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekStatusAnggota
{
    /**
     * Handle an incoming request.
     *
     * Memastikan bahwa anggota yang login memiliki status AKTIF.
     * Jika status NONAKTIF atau DIBLOKIR, logout dan redirect.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $anggota = Auth::guard('anggota')->user();

        if ($anggota && !$anggota->isAktif()) {
            Auth::guard('anggota')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $pesan = match ($anggota->status_anggota) {
                'NONAKTIF' => 'Akun Anda telah dinonaktifkan. Hubungi admin perpustakaan.',
                'DIBLOKIR' => 'Akun Anda telah diblokir. Hubungi admin perpustakaan.',
                default    => 'Akun Anda tidak aktif.',
            };

            return redirect()->route('login')->with('error', $pesan);
        }

        // Cek masa berlaku kartu anggota
        if ($anggota && !$anggota->isMasihBerlaku()) {
            Auth::guard('anggota')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Kartu anggota Anda sudah kedaluwarsa. Hubungi admin untuk perpanjangan.');
        }

        return $next($request);
    }
}
