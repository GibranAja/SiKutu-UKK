@extends('layouts.admin')

@section('title', 'Dashboard Admin - Sikutu')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card bg-blue-500 text-white border-blue-600 hover:-translate-y-1 transform transition-all duration-300">
        <h3 class="font-oswald text-lg font-medium opacity-90">Total Buku</h3>
        <p class="font-montserrat text-3xl font-bold mt-2">{{ number_format($totalBuku) }}</p>
    </div>
    <div class="card bg-emerald-500 text-white border-emerald-600 hover:-translate-y-1 transform transition-all duration-300">
        <h3 class="font-oswald text-lg font-medium opacity-90">Total Anggota</h3>
        <p class="font-montserrat text-3xl font-bold mt-2">{{ number_format($totalAnggota) }}</p>
        <p class="text-sm mt-1 opacity-80">{{ number_format($anggotaAktif) }} Aktif</p>
    </div>
    <div class="card bg-amber-500 text-white border-amber-600 hover:-translate-y-1 transform transition-all duration-300">
        <h3 class="font-oswald text-lg font-medium opacity-90">Peminjaman Aktif</h3>
        <p class="font-montserrat text-3xl font-bold mt-2">{{ number_format($peminjamanAktif) }}</p>
        <p class="text-sm mt-1 opacity-80">Dari total {{ number_format($totalPeminjaman) }}</p>
    </div>
    <div class="card bg-red-500 text-white border-red-600 hover:-translate-y-1 transform transition-all duration-300">
        <h3 class="font-oswald text-lg font-medium opacity-90">Terlambat & Denda</h3>
        <p class="font-montserrat text-3xl font-bold mt-2">{{ number_format($peminjamanTerlambat) }} <span class="text-lg font-normal">buku</span></p>
        <p class="text-sm mt-1 opacity-80">Rp {{ number_format($dendaBelumLunas, 0, ',', '.') }} blm lunas</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="font-oswald text-xl font-semibold text-gray-700">Peminjaman Terbaru</h3>
            <a href="{{ route('admin.peminjaman.index') }}" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 font-oswald">
                    <tr>
                        <th class="px-4 py-3">Peminjam</th>
                        <th class="px-4 py-3">Buku</th>
                        <th class="px-4 py-3">Tgl Pinjam</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamanTerbaru as $p)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $p->anggota->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ Str::limit($p->buku->judul, 20) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $p->status_peminjaman == 'DIPINJAM' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ $p->status_peminjaman }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada data peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="font-oswald text-xl font-semibold text-gray-700">Buku Populer</h3>
            <a href="{{ route('admin.buku.index') }}" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">Kelola Buku</a>
        </div>
        <div class="space-y-4">
            @forelse($bukuPopuler as $buku)
            <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors border border-transparent hover:border-gray-100">
                <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0 shadow-sm">
                    @if($buku->cover_gambar)
                        <img src="{{ Storage::url($buku->cover_gambar) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    @endif
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="font-oswald font-medium text-gray-800">{{ Str::limit($buku->judul, 40) }}</h4>
                    <p class="text-sm text-gray-500">{{ $buku->penulis }}</p>
                </div>
                <div class="ml-4 flex-shrink-0 text-right">
                    <span class="text-lg font-bold text-blue-600">{{ $buku->peminjaman_count }}</span>
                    <span class="text-xs text-gray-500 block">Pinjaman</span>
                </div>
            </div>
            @empty
            <div class="py-8 text-center text-gray-500">Belum ada data buku populer</div>
            @endforelse
        </div>
    </div>
</div>
@endsection