@extends('layouts.anggota')

@section('title', 'Katalog Buku - Sikutu')
@section('header', 'Katalog Buku Perpustakaan')

@section('content')
<div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
    <form action="{{ route('siswa.katalog.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku, pengarang, penerbit..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded font-montserrat focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
        </div>
        
        <div class="w-full md:w-48">
            <x-custom-select name="genre" :options="['' => 'Semua Genre'] + $genres->pluck('nama_genre', 'id_genre')->toArray()" selected="{{ request('genre') }}" placeholder="Semua Genre" />
        </div>

        <div class="w-full md:w-48">
            <x-custom-select name="status" :options="['' => 'Semua Status', 'TERSEDIA' => 'Tersedia', 'TIDAK_TERSEDIA' => 'Tidak Tersedia']" selected="{{ request('status') }}" placeholder="Semua Status" />
        </div>

        <button type="submit" class="btn-primary w-full md:w-auto">Cari</button>
        
        @if(request()->anyFilled(['search', 'genre', 'status']))
            <a href="{{ route('siswa.katalog.index') }}" class="btn-secondary w-full md:w-auto text-center bg-gray-500 hover:bg-gray-600 border-none ring-0">Reset</a>
        @endif
    </form>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-6 mb-8">
    @forelse($bukus as $buku)
    <div class="card p-0 overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-lg transition-all duration-300 group">
        <div class="relative pt-[140%] bg-gray-200 overflow-hidden">
            @if($buku->gambar_cover)
                <img src="{{ Storage::url($buku->gambar_cover) }}" alt="{{ $buku->judul_buku }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            @endif
            
            <div class="absolute top-2 right-2">
                @if($buku->status_buku == 'TERSEDIA' && $buku->kondisi == 'BAIK')
                    <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider bg-emerald-500 text-white rounded shadow">Tersedia</span>
                @else
                    <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider bg-red-500 text-white rounded shadow">Tidak Tersedia</span>
                @endif
            </div>
        </div>
        <div class="p-3 flex-1 flex flex-col bg-white">
            <h3 class="font-oswald text-sm font-medium text-gray-800 line-clamp-2 mb-1 group-hover:text-blue-600 transition-colors" title="{{ $buku->judul_buku }}">{{ $buku->judul_buku }}</h3>
            <p class="text-xs text-gray-500 line-clamp-1 mb-2 flex-1">{{ $buku->pengarang }}</p>
            
            <a href="{{ route('siswa.katalog.show', $buku->uuid) }}" class="mt-auto block w-full text-center py-1.5 px-3 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded transition-colors duration-200 uppercase tracking-wide">
                Detail
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center bg-white rounded-lg border border-dashed border-gray-300">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h3 class="text-lg font-medium text-gray-900 font-oswald mb-1">Tidak Ditemukan</h3>
        <p class="text-gray-500">Buku yang Anda cari tidak ditemukan. Coba kata kunci lain.</p>
    </div>
    @endforelse
</div>

@if($bukus->hasPages())
<div class="flex justify-center mb-8">
    {{ $bukus->links() }}
</div>
@endif
@endsection