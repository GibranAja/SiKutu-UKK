@extends('layouts.anggota')

@section('title', 'Peminjaman Saya - Sikutu')
@section('header', 'Riwayat Peminjaman Buku')

@section('content')
<div class="mb-6">
    <div class="card p-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg rounded-xl flex items-center justify-between">
        <div>
            <h3 class="font-oswald text-xl font-bold">Lacak Peminjamanmu</h3>
            <p class="text-sm text-blue-100 opacity-90 mt-1">Pastikan selalu mengembalikan buku tepat waktu untuk menghindari denda!</p>
        </div>
        <div class="hidden sm:block">
            <svg class="w-12 h-12 text-white opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>

<div class="card p-0 overflow-hidden">
    <div class="p-4 bg-gray-50 border-b flex flex-col sm:flex-row justify-between items-center gap-3">
        <h3 class="font-oswald text-lg font-medium text-gray-800">Daftar Transaksi</h3>
        
        <form action="{{ route('siswa.peminjaman.index') }}" method="GET" class="w-full sm:w-auto flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku..." class="input-field w-full sm:w-auto py-1.5 text-sm">
            
            <div class="w-full sm:w-[200px]">
                <x-custom-select name="status" :options="['' => 'Semua Status', 'DIPINJAM' => 'Dipinjam', 'DIKEMBALIKAN' => 'Dikembalikan', 'MENUNGGU_KONFIRMASI' => 'Menunggu Konfirmasi', 'DITOLAK' => 'Ditolak']" selected="{{ request('status') }}" placeholder="Semua Status" onchange="$el.closest('form').submit()" />
            </div>
            <button type="submit" x-ref="form" class="hidden">Submit</button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('siswa.peminjaman.index') }}" class="btn-secondary py-1.5 px-3 text-sm bg-gray-500 hover:bg-gray-600 text-white border-none">Reset</a>
            @endif
            <button type="submit" class="btn-primary py-1.5 px-3 text-sm">Cari</button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Buku</th>
                    <th class="px-6 py-4">Tgl Pinjam</th>
                    <th class="px-6 py-4">Batas Waktu</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $pinjam)
                @php
                    $isTerlambat = $pinjam->status_peminjaman == 'DIPINJAM' && \Carbon\Carbon::parse($pinjam->tanggal_harus_kembali)->isPast();
                @endphp
                <tr class="border-b hover:bg-gray-50 transition-colors duration-200 {{ $isTerlambat ? 'bg-red-50/50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if(isset($pinjam->buku->gambar_cover))
                                <img src="{{ Storage::url($pinjam->buku->gambar_cover) }}" alt="Cover" class="w-10 h-14 object-cover rounded shadow-sm mr-3">
                            @else
                                <div class="w-10 h-14 bg-gray-200 rounded flex items-center justify-center text-gray-400 shadow-sm mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-gray-800">{{ Str::limit($pinjam->buku->judul_buku ?? 'Buku Dihapus', 40) }}</div>
                                <div class="text-xs text-gray-500">{{ $pinjam->buku->pengarang ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ $isTerlambat ? 'text-red-600 font-bold' : '' }}">
                            {{ \Carbon\Carbon::parse($pinjam->tanggal_harus_kembali)->format('d M Y') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider
                            @if($pinjam->status_peminjaman == 'DIPINJAM') bg-blue-100 text-blue-800 
                            @elseif($pinjam->status_peminjaman == 'DIKEMBALIKAN') bg-emerald-100 text-emerald-800 
                            @elseif($pinjam->status_peminjaman == 'MENUNGGU_KONFIRMASI') bg-amber-100 text-amber-800 
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ str_replace('_', ' ', $pinjam->status_peminjaman) }}
                        </span>
                        @if($isTerlambat)
                            <div class="text-[10px] text-red-600 font-bold mt-1 uppercase">Terlambat</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('siswa.peminjaman.show', $pinjam->uuid) }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 uppercase tracking-wider group">
                            Lihat
                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <p class="text-gray-500 font-medium">Belum ada riwayat peminjaman.</p>
                        <a href="{{ route('siswa.katalog.index') }}" class="inline-block mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium">Mulai Pinjam Buku Sekarang &rarr;</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($peminjamans->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $peminjamans->links() }}
    </div>
    @endif
</div>
@endsection
