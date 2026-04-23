<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\PengaturanDenda;
use App\Models\LogAktivitas;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku', 'petugasKembali']);
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->whereHas('peminjaman', function ($q) use ($s) {
                $q->whereHas('anggota', fn($q2) => $q2->where('nama_lengkap', 'like', "%{$s}%"))
                  ->orWhereHas('buku', fn($q2) => $q2->where('judul_buku', 'like', "%{$s}%"));
            });
        }
        if ($request->filled('status_denda')) {
            $query->where('status_denda', $request->input('status_denda'));
        }
        $pengembalians = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    public function create(Request $request)
    {
        $idPeminjaman = $request->query('peminjaman');
        $peminjaman = null;
        if ($idPeminjaman) {
            $peminjaman = Peminjaman::with(['anggota', 'buku'])->where('status_peminjaman', 'DIPINJAM')->findOrFail($idPeminjaman);
        }
        $peminjamanAktif = Peminjaman::with(['anggota', 'buku'])->where('status_peminjaman', 'DIPINJAM')->orderBy('tanggal_harus_kembali')->get();
        $pengaturan = PengaturanDenda::getAktif();
        return view('admin.pengembalian.create', compact('peminjaman', 'peminjamanAktif', 'pengaturan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman'        => 'required|exists:peminjamans,id_peminjaman|unique:pengembalians,id_peminjaman',
            'tanggal_kembali'      => 'required|date',
            'kondisi_buku_kembali' => 'required|in:BAIK,RUSAK',
            'denda_kondisi'        => 'nullable|numeric|min:0',
            'catatan_petugas'      => 'nullable|string|max:500',
        ]);

        $peminjaman = Peminjaman::with('buku')->findOrFail($request->input('id_peminjaman'));
        $pengaturan = PengaturanDenda::getAktif();
        $tanggalKembali = Carbon::parse($request->input('tanggal_kembali'));

        // Hitung denda keterlambatan
        $hariTerlambat = $peminjaman->hitungHariTerlambatDari($tanggalKembali);
        $dendaKeterlambatan = $pengaturan ? $pengaturan->hitungDendaKeterlambatan($hariTerlambat) : 0;

        // Denda kondisi (manual input jika rusak)
        $dendaKondisi = 0;
        if ($request->input('kondisi_buku_kembali') === 'RUSAK') {
            $dendaKondisi = (float) $request->input('denda_kondisi', 0);
        }

        $dendaTotal = $dendaKeterlambatan + $dendaKondisi;
        $statusDenda = $dendaTotal > 0 ? 'BELUM_LUNAS' : 'TIDAK_ADA';

        $pengembalian = Pengembalian::create([
            'id_peminjaman'        => $peminjaman->id_peminjaman,
            'tanggal_kembali'      => $request->input('tanggal_kembali'),
            'kondisi_buku_kembali' => $request->input('kondisi_buku_kembali'),
            'denda_keterlambatan'  => $dendaKeterlambatan,
            'denda_kondisi'        => $dendaKondisi,
            'denda_total'          => $dendaTotal,
            'status_denda'         => $statusDenda,
            'id_petugas_kembali'   => Auth::guard('admin')->id(),
            'catatan_petugas'      => $request->input('catatan_petugas'),
        ]);

        // Update status peminjaman
        $peminjaman->update(['status_peminjaman' => 'DIKEMBALIKAN']);

        // Tambah stok buku
        $peminjaman->buku->tambahStok();

        // Update kondisi buku jika rusak
        if ($request->input('kondisi_buku_kembali') === 'RUSAK') {
            $peminjaman->buku->update(['kondisi' => 'RUSAK']);
        }

        LogAktivitas::catat(Auth::guard('admin')->id(), 'CREATE_PENGEMBALIAN', 'pengembalian', "Pengembalian buku '{$peminjaman->buku->judul_buku}' oleh anggota. Denda: Rp " . number_format($dendaTotal, 0, ',', '.'), null, $pengembalian->toArray());

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil diproses.' . ($dendaTotal > 0 ? " Denda: Rp " . number_format($dendaTotal, 0, ',', '.') : ''));
    }

    public function show(string $id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku', 'petugasKembali'])->where('uuid', $id)->firstOrFail();
        return view('admin.pengembalian.show', compact('pengembalian'));
    }

    /**
     * Lunaskan denda.
     */
    public function lunaskanDenda(string $id)
    {
        $pengembalian = Pengembalian::with('peminjaman.anggota')->where('uuid', $id)->firstOrFail();
        if (!$pengembalian->adaDenda()) {
            return back()->with('error', 'Tidak ada denda untuk dilunaskan.');
        }
        if ($pengembalian->isDendaLunas()) {
            return back()->with('error', 'Denda sudah lunas.');
        }

        $pengembalian->lunaskanDenda();

        LogAktivitas::catat(Auth::guard('admin')->id(), 'LUNASKAN_DENDA', 'pengembalian', "Melunaskan denda Rp " . number_format($pengembalian->denda_total, 0, ',', '.') . " untuk anggota {$pengembalian->peminjaman->anggota->nama_lengkap}");

        return back()->with('success', 'Denda berhasil dilunaskan.');
    }
}
