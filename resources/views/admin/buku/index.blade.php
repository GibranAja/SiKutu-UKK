@extends('layouts.admin')

@section('title', 'Manajemen Buku - Sikutu')
@section('header', 'Manajemen Buku')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <form action="{{ route('admin.buku.index') }}" method="GET" class="w-full sm:w-auto flex-1 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, pengarang, kode..." class="input-field w-full sm:max-w-xs">
        
        <select name="genre" class="input-field w-full sm:max-w-[150px] bg-white">
            <option value="">Semua Genre</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id_genre }}" {{ request('genre') == $genre->id_genre ? 'selected' : '' }}>{{ $genre->nama_genre }}</option>
            @endforeach
        </select>

        <select name="status" class="input-field w-full sm:max-w-[150px] bg-white">
            <option value="">Semua Status</option>
            <option value="TERSEDIA" {{ request('status') == 'TERSEDIA' ? 'selected' : '' }}>Tersedia</option>
            <option value="TIDAK_TERSEDIA" {{ request('status') == 'TIDAK_TERSEDIA' ? 'selected' : '' }}>Tidak Tersedia</option>
        </select>

        <button type="submit" class="btn-secondary whitespace-nowrap">Filter</button>
        @if(request()->anyFilled(['search', 'genre', 'status']))
            <a href="{{ route('admin.buku.index') }}" class="btn-danger whitespace-nowrap bg-gray-500 hover:bg-gray-600 border-none ring-0">Reset</a>
        @endif
    </form>

    <a href="{{ route('admin.buku.create') }}" class="btn-primary whitespace-nowrap flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Buku
    </a>
</div>

<div class="card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Buku</th>
                    <th class="px-6 py-4">Stok</th>
                    <th class="px-6 py-4">Kondisi</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukus as $buku)
                <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $buku->kode_buku }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($buku->gambar_cover)
                                <img src="{{ Storage::url($buku->gambar_cover) }}" alt="Cover" class="w-10 h-14 object-cover rounded mr-3 shadow-sm">
                            @else
                                <div class="w-10 h-14 bg-gray-200 rounded mr-3 flex items-center justify-center text-gray-400 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div>
                                <div class="font-oswald font-medium text-base text-gray-800">{{ Str::limit($buku->judul_buku, 40) }}</div>
                                <div class="text-xs text-gray-500">{{ $buku->pengarang }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $buku->stok }}</td>
                    <td class="px-6 py-4">
                        @if($buku->kondisi == 'BAIK')
                            <span class="text-emerald-600 font-medium">{{ $buku->kondisi }}</span>
                        @elseif($buku->kondisi == 'RUSAK')
                            <span class="text-orange-600 font-medium">{{ $buku->kondisi }}</span>
                        @else
                            <span class="text-red-600 font-medium">{{ $buku->kondisi }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $buku->status_buku == 'TERSEDIA' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                            {{ str_replace('_', ' ', $buku->status_buku) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.buku.show', $buku->id_buku) }}" class="text-blue-600 hover:text-blue-900 p-1 inline-block transition-transform hover:scale-110" title="Detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('admin.buku.edit', $buku->id_buku) }}" class="text-amber-600 hover:text-amber-900 p-1 inline-block transition-transform hover:scale-110" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.buku.destroy', $buku->id_buku) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
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
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 font-medium">Data buku tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bukus->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $bukus->links() }}
    </div>
    @endif
</div>
@endsection