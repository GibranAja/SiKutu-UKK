@extends('layouts.admin')

@section('title', 'Manajemen Genre - Sikutu')
@section('header', 'Manajemen Genre')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <form action="{{ route('admin.genre.index') }}" method="GET" class="w-full sm:w-auto flex-1 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama genre..." class="input-field w-full sm:max-w-xs">
        <button type="submit" class="btn-secondary whitespace-nowrap">Filter</button>
        @if(request()->filled('search'))
            <a href="{{ route('admin.genre.index') }}" class="btn-danger whitespace-nowrap bg-gray-500 hover:bg-gray-600 border-none ring-0">Reset</a>
        @endif
    </form>

    <a href="{{ route('admin.genre.create') }}" class="btn-primary whitespace-nowrap flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Genre
    </a>
</div>

<div class="card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Nama Genre</th>
                    <th class="px-6 py-4">Deskripsi</th>
                    <th class="px-6 py-4">Jumlah Buku</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($genres as $genre)
                <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $genre->nama_genre }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ Str::limit($genre->deskripsi, 50) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $genre->bukus_count }} Buku</span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.genre.edit', $genre->uuid) }}" class="text-amber-600 hover:text-amber-900 p-1 inline-block transition-transform hover:scale-110" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.genre.destroy', $genre->id_genre) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus genre ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1 transition-transform hover:scale-110" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">Data genre tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($genres->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $genres->links() }}
    </div>
    @endif
</div>
@endsection
