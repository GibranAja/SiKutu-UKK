<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\AnggotaPerpustakaan;
use App\Models\LogAktivitas;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaPerpustakaan::with('adminPendaftar');
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('nis', 'like', "%{$s}%")
                  ->orWhere('username', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status_anggota', $request->input('status'));
        }
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->input('kelas'));
        }
        $anggotas = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        $jurusanList = AnggotaPerpustakaan::getAllJurusan();
        return view('admin.anggota.create', compact('jurusanList'));
    }

    public function store(Request $request)
    {
        $jurusanValid = AnggotaPerpustakaan::getAllJurusan();
        $request->validate([
            'username'      => 'required|string|max:50|unique:anggota_perpustakaan,username|alpha_dash',
            'password'      => 'required|string|min:6',
            'nama_lengkap'  => 'required|string|max:100',
            'nis'           => 'required|string|max:20|unique:anggota_perpustakaan,nis',
            'kelas'         => 'required|in:10,11,12',
            'jurusan'       => 'required|in:' . implode(',', $jurusanValid),
            'alamat'        => 'nullable|string|max:500',
            'no_telepon'    => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:100|unique:anggota_perpustakaan,email',
            'status_anggota' => 'required|in:AKTIF,NONAKTIF,DIBLOKIR',
            'masa_berlaku'  => 'required|date|after:today',
        ]);

        $data = $request->only(['username', 'password', 'nama_lengkap', 'nis', 'kelas', 'jurusan', 'alamat', 'no_telepon', 'email', 'status_anggota', 'masa_berlaku']);
        $data['tanggal_daftar'] = Carbon::now()->toDateString();
        $data['id_admin'] = Auth::guard('admin')->id();

        $anggota = AnggotaPerpustakaan::create($data);

        LogAktivitas::catat(Auth::guard('admin')->id(), 'CREATE_ANGGOTA', 'anggota', "Menambahkan anggota: {$anggota->nama_lengkap} (NIS: {$anggota->nis})", null, $anggota->toArray());

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $anggota = AnggotaPerpustakaan::with(['peminjaman.buku', 'peminjaman.pengembalian', 'adminPendaftar'])->where('uuid', $id)->firstOrFail();
        return view('admin.anggota.show', compact('anggota'));
    }

    public function edit(string $id)
    {
        $anggota = AnggotaPerpustakaan::where('uuid', $id)->firstOrFail();
        $jurusanList = AnggotaPerpustakaan::getAllJurusan();
        return view('admin.anggota.edit', compact('anggota', 'jurusanList'));
    }

    public function update(Request $request, string $id)
    {
        $anggota = AnggotaPerpustakaan::where('uuid', $id)->firstOrFail();
        $jurusanValid = AnggotaPerpustakaan::getAllJurusan();
        $request->validate([
            'username'       => 'required|string|max:50|unique:anggota_perpustakaan,username,' . $anggota->id_anggota . ',id_anggota|alpha_dash',
            'nama_lengkap'   => 'required|string|max:100',
            'nis'            => 'required|string|max:20|unique:anggota_perpustakaan,nis,' . $anggota->id_anggota . ',id_anggota',
            'kelas'          => 'required|in:10,11,12',
            'jurusan'        => 'required|in:' . implode(',', $jurusanValid),
            'alamat'         => 'nullable|string|max:500',
            'no_telepon'     => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:100|unique:anggota_perpustakaan,email,' . $anggota->id_anggota . ',id_anggota',
            'status_anggota' => 'required|in:AKTIF,NONAKTIF,DIBLOKIR',
            'masa_berlaku'   => 'required|date',
        ]);

        $dataLama = $anggota->toArray();
        $data = $request->only(['username', 'nama_lengkap', 'nis', 'kelas', 'jurusan', 'alamat', 'no_telepon', 'email', 'status_anggota', 'masa_berlaku']);
        $anggota->update($data);

        LogAktivitas::catat(Auth::guard('admin')->id(), 'UPDATE_ANGGOTA', 'anggota', "Mengupdate anggota: {$anggota->nama_lengkap}", $dataLama, $anggota->fresh()->toArray());

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $anggota = AnggotaPerpustakaan::where('uuid', $id)->firstOrFail();
        $masihPinjam = $anggota->peminjaman()->where('status_peminjaman', 'DIPINJAM')->exists();
        if ($masihPinjam) {
            return back()->with('error', 'Anggota tidak bisa dihapus karena masih ada peminjaman aktif.');
        }
        $dataLama = $anggota->toArray();
        $anggota->delete();
        LogAktivitas::catat(Auth::guard('admin')->id(), 'DELETE_ANGGOTA', 'anggota', "Menghapus anggota: {$dataLama['nama_lengkap']}", $dataLama, null);
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * Toggle status anggota (AKTIF <-> NONAKTIF).
     */
    public function toggleStatus(string $id)
    {
        $anggota = AnggotaPerpustakaan::where('uuid', $id)->firstOrFail();
        $statusLama = $anggota->status_anggota;
        $anggota->status_anggota = $statusLama === 'AKTIF' ? 'NONAKTIF' : 'AKTIF';
        $anggota->save();

        LogAktivitas::catat(Auth::guard('admin')->id(), 'TOGGLE_STATUS_ANGGOTA', 'anggota', "Mengubah status anggota {$anggota->nama_lengkap} dari {$statusLama} ke {$anggota->status_anggota}", ['status_anggota' => $statusLama], ['status_anggota' => $anggota->status_anggota]);

        return back()->with('success', "Status anggota berhasil diubah menjadi {$anggota->status_anggota}.");
    }

    /**
     * Reset password anggota oleh admin.
     */
    public function resetPassword(Request $request, string $id)
    {
        $anggota = AnggotaPerpustakaan::where('uuid', $id)->firstOrFail();

        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'new_password.required'  => 'Password baru wajib diisi.',
            'new_password.min'       => 'Password minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $anggota->update(['password' => $request->input('new_password')]);

        LogAktivitas::catat(Auth::guard('admin')->id(), 'RESET_PASSWORD_ANGGOTA', 'anggota', "Mereset password anggota: {$anggota->nama_lengkap} (NIS: {$anggota->nis})");

        return back()->with('success', 'Password anggota berhasil direset.');
    }
}
