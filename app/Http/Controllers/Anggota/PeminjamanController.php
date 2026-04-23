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

    public function show(string $id)
    {
        $anggota = Auth::guard('anggota')->user();
        $peminjaman = Peminjaman::with(['buku', 'adminPinjam', 'pengembalian.petugasKembali'])
            ->where('id_anggota', $anggota->id_anggota)
            ->where('uuid', $id)
            ->firstOrFail();

        return view('anggota.peminjaman.show', compact('peminjaman'));
    }

    public function store(Request $request, string $id)
    {
        $buku = \App\Models\Buku::where('uuid', $id)->firstOrFail();
        $anggota = Auth::guard('anggota')->user();

        // Check stock
        if (!$buku->isTersedia()) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam saat ini.');
        }

        // Check if user already borrowed this book and hasn't returned it
        $existing = Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('id_buku', $buku->id_buku)
            ->whereIn('status_peminjaman', ['DIPINJAM', 'MENUNGGU_KONFIRMASI'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Anda masih meminjam atau sedang meminta peminjaman buku ini.');
        }

        $request->validate([
            'tanggal_harus_kembali' => 'required|date|after:today',
        ], [
            'tanggal_harus_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_harus_kembali.after' => 'Tanggal kembali harus lebih dari hari ini.',
        ]);

        Peminjaman::create([
            'id_anggota' => $anggota->id_anggota,
            'id_buku' => $buku->id_buku,
            'id_admin_pinjam' => null, // Will be set when admin confirms
            'tanggal_pinjam' => \Carbon\Carbon::now()->toDateString(),
            'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
            'status_peminjaman' => 'MENUNGGU_KONFIRMASI',
        ]);

        return redirect()->route('siswa.peminjaman.index')->with('success', 'Permintaan peminjaman berhasil dikirim. Menunggu konfirmasi admin.');
    }
}
