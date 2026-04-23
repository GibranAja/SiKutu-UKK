<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AnggotaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Memastikan bahwa user sudah login sebagai anggota perpustakaan.
     * Jika belum, redirect ke halaman login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('anggota')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login sebagai siswa terlebih dahulu.');
        }

        return $next($request);
    }
}
