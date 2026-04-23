<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\AnggotaPerpustakaan;
use App\Models\Buku;
use App\Models\PengaturanDenda;
use App\Models\LogAktivitas;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku', 'adminPinjam', 'pengembalian']);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->whereHas('anggota', fn($q2) => $q2->where('nama_lengkap', 'like', "%{$s}%")->orWhere('nis', 'like', "%{$s}%"))
                  ->orWhereHas('buku', fn($q2) => $q2->where('judul_buku', 'like', "%{$s}%")->orWhere('kode_buku', 'like', "%{$s}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->input('status'));
        }

        if ($request->filled('terlambat') && $request->input('terlambat') === '1') {
            $query->where('status_peminjaman', 'DIPINJAM')
                  ->where('tanggal_harus_kembali', '<', Carbon::now()->toDateString());
        }

        $peminjamans = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $anggotas = AnggotaPerpustakaan::where('status_anggota', 'AKTIF')->orderBy('nama_lengkap')->get();
        $bukus = Buku::where('status_buku', 'TERSEDIA')->where('stok', '>', 0)->orderBy('judul_buku')->get();
        $pengaturan = PengaturanDenda::getAktif();
        $maksHari = $pengaturan ? $pengaturan->maks_hari_pinjam : 7;

        return view('admin.peminjaman.create', compact('anggotas', 'bukus', 'maksHari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota'            => 'required|exists:anggota_perpustakaan,id_anggota',
            'id_buku'               => 'required|exists:bukus,id_buku',
            'tanggal_pinjam'        => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'catatan_peminjaman'    => 'nullable|string|max:500',
        ]);

        $buku = Buku::findOrFail($request->input('id_buku'));
        if (!$buku->isTersedia()) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam.')->withInput();
        }

        $anggota = AnggotaPerpustakaan::findOrFail($request->input('id_anggota'));
        if (!$anggota->isAktif()) {
            return back()->with('error', 'Anggota tidak aktif.')->withInput();
        }

        // Cek apakah anggota sudah meminjam buku yang sama dan belum dikembalikan
        $sudahPinjam = Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('id_buku', $buku->id_buku)
            ->where('status_peminjaman', 'DIPINJAM')
            ->exists();

        if ($sudahPinjam) {
            return back()->with('error', 'Anggota sudah meminjam buku ini dan belum dikembalikan.')->withInput();
        }

        $peminjaman = Peminjaman::create([
            'id_anggota'            => $request->input('id_anggota'),
            'id_buku'               => $request->input('id_buku'),
            'id_admin_pinjam'       => Auth::guard('admin')->id(),
            'tanggal_pinjam'        => $request->input('tanggal_pinjam'),
            'tanggal_harus_kembali' => $request->input('tanggal_harus_kembali'),
            'status_peminjaman'     => 'DIPINJAM',
            'catatan_peminjaman'    => $request->input('catatan_peminjaman'),
        ]);

        $buku->kurangiStok();

        LogAktivitas::catat(Auth::guard('admin')->id(), 'CREATE_PEMINJAMAN', 'peminjaman', "Peminjaman buku '{$buku->judul_buku}' oleh {$anggota->nama_lengkap}", null, $peminjaman->toArray());

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(string $uuid)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku', 'adminPinjam', 'pengembalian.petugasKembali'])->where('uuid', $uuid)->firstOrFail();
        $pengaturan = PengaturanDenda::getAktif();
        return view('admin.peminjaman.show', compact('peminjaman', 'pengaturan'));
    }

    public function edit(string $uuid)
    {
        $peminjaman = Peminjaman::where('uuid', $uuid)->firstOrFail();
        if ($peminjaman->isDikembalikan()) {
            return back()->with('error', 'Peminjaman yang sudah dikembalikan tidak bisa diedit.');
        }
        $anggotas = AnggotaPerpustakaan::where('status_anggota', 'AKTIF')->orderBy('nama_lengkap')->get();
        $bukus = Buku::where(function ($q) use ($peminjaman) {
            $q->where('status_buku', 'TERSEDIA')->where('stok', '>', 0)->orWhere('id_buku', $peminjaman->id_buku);
        })->orderBy('judul_buku')->get();

        return view('admin.peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    public function update(Request $request, string $uuid)
    {
        $peminjaman = Peminjaman::where('uuid', $uuid)->firstOrFail();
        if ($peminjaman->isDikembalikan()) {
            return back()->with('error', 'Peminjaman yang sudah dikembalikan tidak bisa diedit.');
        }

        $request->validate([
            'tanggal_harus_kembali' => 'required|date|after_or_equal:' . $peminjaman->tanggal_pinjam->format('Y-m-d'),
            'catatan_peminjaman'    => 'nullable|string|max:500',
        ]);

        $dataLama = $peminjaman->toArray();
        $peminjaman->update($request->only(['tanggal_harus_kembali', 'catatan_peminjaman']));

        LogAktivitas::catat(Auth::guard('admin')->id(), 'UPDATE_PEMINJAMAN', 'peminjaman', "Mengupdate peminjaman #{$peminjaman->id_peminjaman}", $dataLama, $peminjaman->fresh()->toArray());

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(string $uuid)
    {
        $peminjaman = Peminjaman::with('buku')->where('uuid', $uuid)->firstOrFail();
        if ($peminjaman->status_peminjaman === 'DIPINJAM') {
            $peminjaman->buku->tambahStok();
        }
        $dataLama = $peminjaman->toArray();
        $peminjaman->delete();

        LogAktivitas::catat(Auth::guard('admin')->id(), 'DELETE_PEMINJAMAN', 'peminjaman', "Menghapus peminjaman #{$dataLama['id_peminjaman']}", $dataLama, null);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function terima(string $uuid)
    {
        $peminjaman = Peminjaman::with('buku')->where('uuid', $uuid)->firstOrFail();

        // Cek apakah status adalah MENUNGGU_KONFIRMASI
        if ($peminjaman->status_peminjaman !== 'MENUNGGU_KONFIRMASI') {
            return back()->with('error', 'Peminjaman ini tidak dapat diterima.');
        }

        // Cek apakah buku masih tersedia
        if (!$peminjaman->buku->isTersedia()) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        $dataLama = $peminjaman->toArray();

        // Update status
        $peminjaman->update([
            'status_peminjaman' => 'DIPINJAM',
            'id_admin_pinjam' => Auth::guard('admin')->id(),
        ]);

        // Kurangi stok buku
        $peminjaman->buku->kurangiStok();

        LogAktivitas::catat(
            Auth::guard('admin')->id(),
            'APPROVE_PEMINJAMAN',
            'peminjaman',
            "Menerima peminjaman buku '{$peminjaman->buku->judul_buku}' oleh {$peminjaman->anggota->nama_lengkap}",
            $dataLama,
            $peminjaman->fresh()->toArray()
        );

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil diterima.');
    }

    public function tolak(string $uuid)
    {
        $peminjaman = Peminjaman::where('uuid', $uuid)->firstOrFail();

        // Cek apakah status adalah MENUNGGU_KONFIRMASI
        if ($peminjaman->status_peminjaman !== 'MENUNGGU_KONFIRMASI') {
            return back()->with('error', 'Peminjaman ini tidak dapat ditolak.');
        }

        $dataLama = $peminjaman->toArray();

        // Update status ke DITOLAK
        $peminjaman->update([
            'status_peminjaman' => 'DITOLAK',
        ]);

        LogAktivitas::catat(
            Auth::guard('admin')->id(),
            'REJECT_PEMINJAMAN',
            'peminjaman',
            "Menolak peminjaman buku '{$peminjaman->buku->judul_buku}' oleh {$peminjaman->anggota->nama_lengkap}",
            $dataLama,
            $peminjaman->fresh()->toArray()
        );

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditolak.');
    }
}
