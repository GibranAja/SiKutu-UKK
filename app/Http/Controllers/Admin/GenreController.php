<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Genre;
use App\Models\LogAktivitas;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $query = Genre::withCount('bukus');
        if ($request->filled('search')) {
            $query->where('nama_genre', 'like', '%' . $request->input('search') . '%');
        }
        $genres = $query->orderBy('nama_genre')->paginate(15);
        return view('admin.genre.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genre.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_genre' => 'required|string|max:100|unique:genres,nama_genre',
            'deskripsi'  => 'nullable|string|max:500',
        ]);
        $genre = Genre::create($request->only(['nama_genre', 'deskripsi']));
        LogAktivitas::catat(Auth::guard('admin')->id(), 'CREATE_GENRE', 'genre', "Menambahkan genre: {$genre->nama_genre}", null, $genre->toArray());
        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $genre = Genre::where('uuid', $id)->firstOrFail();
        return view('admin.genre.edit', compact('genre'));
    }

    public function update(Request $request, string $id)
    {
        $genre = Genre::where('uuid', $id)->firstOrFail();
        $request->validate([
            'nama_genre' => 'required|string|max:100|unique:genres,nama_genre,' . $genre->id_genre . ',id_genre',
            'deskripsi'  => 'nullable|string|max:500',
        ]);
        $dataLama = $genre->toArray();
        $genre->update($request->only(['nama_genre', 'deskripsi']));
        LogAktivitas::catat(Auth::guard('admin')->id(), 'UPDATE_GENRE', 'genre', "Mengupdate genre: {$genre->nama_genre}", $dataLama, $genre->fresh()->toArray());
        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $genre = Genre::withCount('bukus')->findOrFail($id);
        if ($genre->bukus_count > 0) {
            return back()->with('error', "Genre tidak bisa dihapus karena masih digunakan oleh {$genre->bukus_count} buku.");
        }
        $dataLama = $genre->toArray();
        $genre->delete();
        LogAktivitas::catat(Auth::guard('admin')->id(), 'DELETE_GENRE', 'genre', "Menghapus genre: {$dataLama['nama_genre']}", $dataLama, null);
        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil dihapus.');
    }
}
