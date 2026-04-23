<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengembalian;

class DendaController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();

        $dendas = Pengembalian::with(['peminjaman.buku'])
            ->whereHas('peminjaman', fn($q) => $q->where('id_anggota', $anggota->id_anggota))
            ->where('denda_total', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalBelumLunas = Pengembalian::whereHas('peminjaman', fn($q) => $q->where('id_anggota', $anggota->id_anggota))
            ->where('status_denda', 'BELUM_LUNAS')
            ->sum('denda_total');

        return view('anggota.denda.index', compact('dendas', 'totalBelumLunas'));
    }
}
