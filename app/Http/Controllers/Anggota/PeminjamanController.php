<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        $query = Peminjaman::with(['buku', 'pengembalian'])->where('id_anggota', $anggota->id_anggota);

        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->input('status'));
        }

        $peminjamans = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('anggota.peminjaman.index', compact('peminjamans'));
    }

    public function show(int $id)
    {
        $anggota = Auth::guard('anggota')->user();
        $peminjaman = Peminjaman::with(['buku', 'adminPinjam', 'pengembalian.petugasKembali'])
            ->where('id_anggota', $anggota->id_anggota)
            ->findOrFail($id);

        return view('anggota.peminjaman.show', compact('peminjaman'));
    }
}
