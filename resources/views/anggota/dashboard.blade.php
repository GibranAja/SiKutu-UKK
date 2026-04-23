@extends('layouts.anggota')

@section('title', 'Dashboard Siswa - Sikutu')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card bg-blue-500 text-white border-blue-600 hover:-translate-y-1 transform transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-oswald text-lg font-medium opacity-90">Sedang Dipinjam</h3>
                <p class="font-montserrat text-4xl font-bold mt-1">{{ $jumlahDipinjam }}</p>
            </div>
            <div class="p-3 bg-white bg-opacity-20 rounded-full">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
    </div>
    
    <div class="card {{ $jumlahTerlambat > 0 ? 'bg-red-500 border-red-600' : 'bg-emerald-500 border-emerald-600' }} text-white hover:-translate-y-1 transform transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-oswald text-lg font-medium opacity-90">Terlambat</h3>
                <p class="font-montserrat text-4xl font-bold mt-1">{{ $jumlahTerlambat }}</p>
            </div>
            <div class="p-3 bg-white bg-opacity-20 rounded-full">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card {{ $totalDendaBelumLunas > 0 ? 'bg-amber-500 border-amber-600' : 'bg-gray-700 border-gray-800' }} text-white hover:-translate-y-1 transform transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-oswald text-lg font-medium opacity-90">Tagihan Denda</h3>
                <p class="font-montserrat text-2xl sm:text-3xl font-bold mt-1">Rp {{ number_format($totalDendaBelumLunas, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-white bg-opacity-20 rounded-full hidden sm:block">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="font-oswald text-xl font-semibold text-gray-700">Peminjaman Aktif</h3>
        </div>
        <div class="space-y-4">
            @forelse($peminjamanAktif as $p)
            <div class="flex flex-col sm:flex-row items-start sm:items-center p-4 border rounded-lg hover:shadow-md transition-shadow duration-300 {{ $p->isTerlambat() ? 'border-red-200 bg-red-50' : 'border-gray-200 bg-white' }}">
                <div class="flex-1 w-full mb-3 sm:mb-0">
                    <h4 class="font-oswald font-medium text-lg text-gray-800">{{ $p->buku->judul }}</h4>
                    <p class="text-sm text-gray-600 mt-1">
                        <span class="inline-block w-24">Tgl Pinjam</span>: <span class="font-medium">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</span>
                    </p>
                    <p class="text-sm {{ $p->isTerlambat() ? 'text-red-600 font-bold' : 'text-gray-600' }} mt-1">
                        <span class="inline-block w-24">Harus Kembali</span>: <span>{{ \Carbon\Carbon::parse($p->tanggal_harus_kembali)->format('d M Y') }}</span>
                    </p>
                </div>
                <div class="flex-shrink-0 w-full sm:w-auto text-left sm:text-right">
                    @if($p->isTerlambat())
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">Terlambat</span>
                    @else
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">Sedang Dipinjam</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-8 text-center text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <p>Kamu tidak memiliki peminjaman aktif saat ini.</p>
                <a href="{{ route('siswa.katalog.index') }}" class="btn-primary mt-4 inline-block">Jelajahi Katalog</a>
            </div>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="font-oswald text-xl font-semibold text-gray-700">Histori Peminjaman Terakhir</h3>
            <a href="{{ route('siswa.peminjaman.index') }}" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($historiTerbaru as $histori)
            <div class="flex items-center p-3 border border-gray-100 rounded hover:bg-gray-50 transition-colors">
                <div class="flex-1">
                    <h4 class="font-oswald font-medium text-gray-800 truncate" title="{{ $histori->buku->judul }}">{{ Str::limit($histori->buku->judul, 35) }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($histori->tanggal_pinjam)->format('d M Y') }}</p>
                </div>
                <div class="ml-4 text-right">
                    @if($histori->status_peminjaman == 'DIKEMBALIKAN')
                        <span class="text-xs font-semibold text-emerald-600">Selesai</span>
                        @if($histori->pengembalian && $histori->pengembalian->keterlambatan_hari > 0)
                            <p class="text-xs text-red-500 mt-1">Telat {{ $histori->pengembalian->keterlambatan_hari }} hari</p>
                        @endif
                    @elseif($histori->status_peminjaman == 'HILANG')
                        <span class="text-xs font-semibold text-red-600">Hilang</span>
                    @elseif($histori->status_peminjaman == 'RUSAK')
                        <span class="text-xs font-semibold text-orange-600">Rusak</span>
                    @else
                        <span class="text-xs font-semibold text-blue-600">Aktif</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-8 text-center text-gray-500">Belum ada histori peminjaman.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection