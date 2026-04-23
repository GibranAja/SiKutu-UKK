@extends('layouts.admin')

@section('title', 'Recycle Bin - Sikutu')
@section('header', 'Recycle Bin')

@section('content')
<div class="mb-6 flex space-x-4 border-b border-gray-200">
    <a href="{{ route('admin.recycle-bin.index', ['tab' => 'buku']) }}" class="py-2 px-4 font-oswald text-lg {{ $tab === 'buku' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
        Buku Terhapus
    </a>
    <a href="{{ route('admin.recycle-bin.index', ['tab' => 'genre']) }}" class="py-2 px-4 font-oswald text-lg {{ $tab === 'genre' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
        Genre Terhapus
    </a>
</div>

@if($tab === 'buku')
<div class="card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Cover</th>
                    <th class="px-6 py-4">Judul Buku</th>
                    <th class="px-6 py-4">Dihapus Pada</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukus as $buku)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        @if($buku->gambar_cover)
                            <img src="{{ Storage::url($buku->gambar_cover) }}" alt="Cover" class="w-12 h-16 object-cover rounded shadow-sm">
                        @else
                            <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $buku->judul_buku }}</div>
                        <div class="text-xs text-gray-500">{{ $buku->kode_buku }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $buku->deleted_at->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <form action="{{ route('admin.recycle-bin.restore.buku', $buku->uuid) }}" method="POST" class="inline-block" onsubmit="return confirm('Restore buku ini?');">
                            @csrf
                            <button type="submit" class="text-emerald-600 hover:text-emerald-900 p-1" title="Restore">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </button>
                        </form>
                        <form action="{{ route('admin.recycle-bin.force-delete.buku', $buku->uuid) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus permanen buku ini? Tindakan ini tidak dapat dibatalkan!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Hapus Permanen">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Recycle Bin kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bukus->hasPages())
    <div class="px-6 py-4 border-t bg-gray-50">{{ $bukus->appends(['tab' => 'buku'])->links() }}</div>
    @endif
</div>
@endif

@if($tab === 'genre')
<div class="card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Nama Genre</th>
                    <th class="px-6 py-4">Dihapus Pada</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($genres as $genre)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $genre->nama_genre }}</td>
                    <td class="px-6 py-4">{{ $genre->deleted_at->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <form action="{{ route('admin.recycle-bin.restore.genre', $genre->id_genre) }}" method="POST" class="inline-block" onsubmit="return confirm('Restore genre ini?');">
                            @csrf
                            <button type="submit" class="text-emerald-600 hover:text-emerald-900 p-1" title="Restore">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </button>
                        </form>
                        <form action="{{ route('admin.recycle-bin.force-delete.genre', $genre->id_genre) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus permanen genre ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Hapus Permanen">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-8 text-center text-gray-500">Recycle Bin kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($genres->hasPages())
    <div class="px-6 py-4 border-t bg-gray-50">{{ $genres->appends(['tab' => 'genre'])->links() }}</div>
    @endif
</div>
@endif
@endsection
