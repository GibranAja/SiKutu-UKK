<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * Jika user sudah login, redirect ke dashboard sesuai role.
     * Digunakan untuk halaman login/register agar user yang sudah
     * login tidak bisa mengakses halaman tersebut lagi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('anggota')->check()) {
            return redirect()->route('siswa.dashboard');
        }

        return $next($request);
    }
}
