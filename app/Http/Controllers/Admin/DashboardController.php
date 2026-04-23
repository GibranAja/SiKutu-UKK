<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\AnggotaPerpustakaan;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\LogAktivitas;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan statistik.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        // Statistik utama
        $totalBuku            = Buku::count();
        $totalAnggota         = AnggotaPerpustakaan::count();
        $anggotaAktif         = AnggotaPerpustakaan::where('status_anggota', 'AKTIF')->count();
        $totalPeminjaman      = Peminjaman::count();
        $peminjamanAktif      = Peminjaman::where('status_peminjaman', 'DIPINJAM')->count();
        $peminjamanTerlambat  = Peminjaman::where('status_peminjaman', 'DIPINJAM')
                                          ->where('tanggal_harus_kembali', '<', Carbon::now()->toDateString())
                                          ->count();

        // Peminjaman terbaru (5 terakhir)
        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
                                       ->orderBy('created_at', 'desc')
                                       ->limit(5)
                                       ->get();

        // Pengembalian terbaru (5 terakhir)
        $pengembalianTerbaru = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
                                           ->orderBy('created_at', 'desc')
                                           ->limit(5)
                                           ->get();

        // Denda belum lunas
        $dendaBelumLunas = Pengembalian::where('status_denda', 'BELUM_LUNAS')
                                       ->sum('denda_total');

        // Buku paling populer (paling banyak dipinjam)
        $bukuPopuler = Buku::withCount('peminjaman')
                           ->orderBy('peminjaman_count', 'desc')
                           ->limit(5)
                           ->get();

        // Log aktivitas terbaru (10 terakhir)
        $logTerbaru = LogAktivitas::with('admin')
                                  ->orderBy('created_at', 'desc')
                                  ->limit(10)
                                  ->get();

        return view('admin.dashboard', compact(
            'admin',
            'totalBuku',
            'totalAnggota',
            'anggotaAktif',
            'totalPeminjaman',
            'peminjamanAktif',
            'peminjamanTerlambat',
            'peminjamanTerbaru',
            'pengembalianTerbaru',
            'dendaBelumLunas',
            'bukuPopuler',
            'logTerbaru'
        ));
    }
}
