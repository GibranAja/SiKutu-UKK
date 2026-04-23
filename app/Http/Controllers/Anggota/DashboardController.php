<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();

        $peminjamanAktif = Peminjaman::with('buku')
            ->where('id_anggota', $anggota->id_anggota)
            ->where('status_peminjaman', 'DIPINJAM')
            ->orderBy('tanggal_harus_kembali')
            ->get();

        $jumlahDipinjam = $peminjamanAktif->count();

        $jumlahTerlambat = $peminjamanAktif->filter(fn($p) => $p->isTerlambat())->count();

        $totalPeminjaman = Peminjaman::where('id_anggota', $anggota->id_anggota)->count();

        // Denda belum lunas
        $dendaBelumLunas = Pengembalian::whereHas('peminjaman', fn($q) => $q->where('id_anggota', $anggota->id_anggota))
            ->whereIn('status_denda', ['BELUM_LUNAS', 'DITOLAK'])
            ->get();

        $totalDendaBelumLunas = $dendaBelumLunas->sum('denda_total');

        // Histori terbaru (5 terakhir)
        $historiTerbaru = Peminjaman::with(['buku', 'pengembalian'])
            ->where('id_anggota', $anggota->id_anggota)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('anggota.dashboard', compact(
            'anggota', 'peminjamanAktif', 'jumlahDipinjam',
            'jumlahTerlambat', 'totalPeminjaman', 'dendaBelumLunas',
            'totalDendaBelumLunas', 'historiTerbaru'
        ));
    }
}
