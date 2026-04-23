<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Buku;
use App\Models\Genre;
use App\Models\LogAktivitas;

class BukuController extends Controller
{
    /**
     * Tampilkan daftar semua buku.
     */
    public function index(Request $request)
    {
        $query = Buku::with('genres');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status_buku', $request->input('status'));
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->input('kondisi'));
        }

        // Filter genre
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id_genre', $request->input('genre'));
            });
        }

        $bukus  = $query->orderBy('created_at', 'desc')->paginate(15);
        $genres = Genre::orderBy('nama_genre')->get();

        return view('admin.buku.index', compact('bukus', 'genres'));
    }

    /**
     * Tampilkan form tambah buku baru.
     */
    public function create()
    {
        $genres = Genre::orderBy('nama_genre')->get();
        return view('admin.buku.create', compact('genres'));
    }

    /**
     * Simpan buku baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'    => 'required|string|max:50|unique:bukus,kode_buku',
            'judul_buku'   => 'required|string|max:255',
            'pengarang'    => 'required|string|max:150',
            'penerbit'     => 'nullable|string|max:150',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'jenis_buku'   => 'nullable|string|max:50',
            'stok'         => 'required|integer|min:0',
            'kondisi'      => 'required|in:BAIK,RUSAK,HILANG',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'genres'       => 'nullable|array',
            'genres.*'     => 'exists:genres,id_genre',
        ], [
            'kode_buku.required'  => 'Kode buku wajib diisi.',
            'kode_buku.unique'    => 'Kode buku sudah ada.',
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'pengarang.required'  => 'Pengarang wajib diisi.',
            'stok.required'       => 'Stok wajib diisi.',
            'stok.min'            => 'Stok tidak boleh negatif.',
            'kondisi.required'    => 'Kondisi wajib dipilih.',
            'gambar_cover.image'  => 'File harus berupa gambar.',
            'gambar_cover.max'    => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->only([
            'kode_buku', 'judul_buku', 'pengarang', 'penerbit',
            'tahun_terbit', 'jenis_buku', 'stok', 'kondisi',
        ]);

        // Tentukan status berdasarkan stok
        $data['status_buku'] = $request->input('stok') > 0 ? 'TERSEDIA' : 'TIDAK_TERSEDIA';

        // Upload gambar cover
        if ($request->hasFile('gambar_cover')) {
            $data['gambar_cover'] = $request->file('gambar_cover')
                                           ->store('covers', 'public');
        }

        $buku = Buku::create($data);

        // Attach genres
        if ($request->filled('genres')) {
            $buku->genres()->attach($request->input('genres'));
        }

        // Log aktivitas
        LogAktivitas::catat(
            Auth::guard('admin')->id(),
            'CREATE_BUKU',
            'buku',
            "Menambahkan buku: {$buku->judul_buku} (Kode: {$buku->kode_buku})",
            null,
            $buku->toArray()
        );

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail buku.
     */
    public function show(string $id)
    {
        $buku = Buku::with(['genres', 'peminjaman.anggota'])->where('uuid', $id)->firstOrFail();
        return view('admin.buku.show', compact('buku'));
    }

    /**
     * Tampilkan form edit buku.
     */
    public function edit(string $id)
    {
        $buku   = Buku::with('genres')->where('uuid', $id)->firstOrFail();
        $genres = Genre::orderBy('nama_genre')->get();
        return view('admin.buku.edit', compact('buku', 'genres'));
    }

    /**
     * Update data buku.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::where('uuid', $id)->firstOrFail();

        $request->validate([
            'kode_buku'    => 'required|string|max:50|unique:bukus,kode_buku,' . $buku->id_buku . ',id_buku',
            'judul_buku'   => 'required|string|max:255',
            'pengarang'    => 'required|string|max:150',
            'penerbit'     => 'nullable|string|max:150',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'jenis_buku'   => 'nullable|string|max:50',
            'stok'         => 'required|integer|min:0',
            'kondisi'      => 'required|in:BAIK,RUSAK,HILANG',
            'gambar_cover_base64' => 'nullable|string',
            'genres'       => 'nullable|array',
            'genres.*'     => 'exists:genres,id_genre',
        ], [
            'kode_buku.required'  => 'Kode buku wajib diisi.',
            'kode_buku.unique'    => 'Kode buku sudah ada.',
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'pengarang.required'  => 'Pengarang wajib diisi.',
            'stok.required'       => 'Stok wajib diisi.',
            'stok.min'            => 'Stok tidak boleh negatif.',
            'kondisi.required'    => 'Kondisi wajib dipilih.',
        ]);

        $dataLama = $buku->toArray();

        $data = $request->only([
            'kode_buku', 'judul_buku', 'pengarang', 'penerbit',
            'tahun_terbit', 'jenis_buku', 'stok', 'kondisi',
        ]);

        // Update status berdasarkan stok
        $data['status_buku'] = $request->input('stok') > 0 ? 'TERSEDIA' : 'TIDAK_TERSEDIA';

        // Upload gambar cover baru
        if ($request->filled('gambar_cover_base64')) {
            $base64 = $request->input('gambar_cover_base64');
            // If base64 contains the data
            if (str_contains($base64, ';base64,')) {
                @list($type, $file_data) = explode(';', $base64);
                @list(, $file_data)      = explode(',', $file_data);
                
                $extension = 'jpg';
                if (str_contains($type, 'png')) $extension = 'png';
                else if (str_contains($type, 'webp')) $extension = 'webp';
                
                $fileName = 'covers/' . \Illuminate\Support\Str::uuid() . '.' . $extension;
                
                // Hapus gambar lama
                if ($buku->gambar_cover) {
                    Storage::disk('public')->delete($buku->gambar_cover);
                }
                
                Storage::disk('public')->put($fileName, base64_decode($file_data));
                $data['gambar_cover'] = $fileName;
            }
        }

        $buku->update($data);

        // Sync genres
        $buku->genres()->sync($request->input('genres', []));

        // Log aktivitas
        LogAktivitas::catat(
            Auth::guard('admin')->id(),
            'UPDATE_BUKU',
            'buku',
            "Mengupdate buku: {$buku->judul_buku} (Kode: {$buku->kode_buku})",
            $dataLama,
            $buku->fresh()->toArray()
        );

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Hapus buku.
     */
    public function destroy(string $id)
    {
        $buku = Buku::where('uuid', $id)->firstOrFail();

        // Cek apakah buku masih dipinjam
        $masihDipinjam = $buku->peminjaman()
                              ->where('status_peminjaman', 'DIPINJAM')
                              ->exists();

        if ($masihDipinjam) {
            return back()->with('error', 'Buku tidak bisa dihapus karena masih ada peminjaman aktif.');
        }

        $dataLama = $buku->toArray();

        // Hapus gambar cover
        if ($buku->gambar_cover) {
            Storage::disk('public')->delete($buku->gambar_cover);
        }

        // Detach genres
        $buku->genres()->detach();

        $buku->delete();

        // Log aktivitas
        LogAktivitas::catat(
            Auth::guard('admin')->id(),
            'DELETE_BUKU',
            'buku',
            "Menghapus buku: {$dataLama['judul_buku']} (Kode: {$dataLama['kode_buku']})",
            $dataLama,
            null
        );

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}
