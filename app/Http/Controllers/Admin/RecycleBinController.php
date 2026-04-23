<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Genre;

class RecycleBinController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'buku');
        
        $bukus = Buku::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10, ['*'], 'buku_page');
        $genres = Genre::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10, ['*'], 'genre_page');
        
        return view('admin.recycle-bin.index', compact('tab', 'bukus', 'genres'));
    }

    public function restoreBuku($id)
    {
        $buku = Buku::onlyTrashed()->where('uuid', $id)->firstOrFail();
        $buku->restore();
        
        return back()->with('success', 'Buku berhasil di-restore dari Recycle Bin.');
    }

    public function forceDeleteBuku($id)
    {
        $buku = Buku::onlyTrashed()->where('uuid', $id)->firstOrFail();
        $buku->forceDelete();
        
        return back()->with('success', 'Buku dihapus permanen.');
    }

    public function restoreGenre($id)
    {
        $genre = Genre::onlyTrashed()->findOrFail($id);
        $genre->restore();
        
        return back()->with('success', 'Genre berhasil di-restore dari Recycle Bin.');
    }

    public function forceDeleteGenre($id)
    {
        $genre = Genre::onlyTrashed()->findOrFail($id);
        $genre->forceDelete();
        
        return back()->with('success', 'Genre dihapus permanen.');
    }
}
