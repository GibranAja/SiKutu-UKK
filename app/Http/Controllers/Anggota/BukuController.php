<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Genre;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('genres');

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('judul_buku', 'like', "%{$s}%")
                  ->orWhere('pengarang', 'like', "%{$s}%")
                  ->orWhere('penerbit', 'like', "%{$s}%");
            });
        }

        if ($request->filled('genre')) {
            $query->whereHas('genres', fn($q) => $q->where('genres.id_genre', $request->input('genre')));
        }

        if ($request->filled('status')) {
            $query->where('status_buku', $request->input('status'));
        }

        $bukus = $query->orderBy('judul_buku')->paginate(12);
        $genres = Genre::orderBy('nama_genre')->get();

        return view('anggota.katalog.index', compact('bukus', 'genres'));
    }

    public function show(string $id)
    {
        $buku = Buku::with('genres')->where('uuid', $id)->firstOrFail();
        return view('anggota.katalog.show', compact('buku'));
    }
}
