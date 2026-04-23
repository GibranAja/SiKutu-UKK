@extends('layouts.anggota')

@section('title', 'Detail Transaksi - Sikutu')
@section('header', 'Detail Peminjaman')

@section('content')
<div class="mb-4">
    <a href="{{ route('siswa.peminjaman.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Transaksi
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-[fadeIn_0.3s_ease-in-out]">
    
    <div class="lg:col-span-2 space-y-6">
        <div class="card p-0 overflow-hidden">
            <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                <h3 class="font-oswald text-lg font-medium text-gray-800">Status Peminjaman</h3>
                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider
                    @if($peminjaman->status_peminjaman == 'DIPINJAM') bg-blue-100 text-blue-800 
                    @elseif($peminjaman->status_peminjaman == 'DIKEMBALIKAN') bg-emerald-100 text-emerald-800 
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ $peminjaman->status_peminjaman }}
                </span>
            </div>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="w-24 flex-shrink-0">
                        @if(isset($peminjaman->buku->gambar_cover))
                            <img src="{{ Storage::url($peminjaman->buku->gambar_cover) }}" alt="Cover" class="w-full rounded shadow-md object-cover">
                        @else
                            <div class="w-full aspect-[2/3] bg-gray-200 rounded flex items-center justify-center text-gray-400 shadow-md">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 font-semibold uppercase mb-1">Buku yang Dipinjam</p>
                        <h4 class="font-oswald text-xl font-medium text-gray-800 mb-1">{{ $peminjaman->buku->judul_buku ?? 'Buku Dihapus' }}</h4>
                        <p class="text-sm text-gray-600 mb-4">{{ $peminjaman->buku->pengarang ?? '-' }} | {{ $peminjaman->buku->penerbit ?? '-' }}</p>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm mt-4 border-t pt-4">
                            <div>
                                <span class="block text-gray-500 text-xs uppercase mb-1">Tanggal Pinjam</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase mb-1">Batas Kembali</span>
                                @php
                                    $isTerlambat = $peminjaman->status_peminjaman == 'DIPINJAM' && \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->isPast();
                                @endphp
                                <span class="font-medium {{ $isTerlambat ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->format('d F Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($peminjaman->pengembalian)
        <div class="card p-0 overflow-hidden border-t-4 border-t-emerald-500">
            <div class="p-4 bg-emerald-50 border-b border-emerald-100">
                <h3 class="font-oswald text-lg font-medium text-emerald-800">Detail Pengembalian</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <span class="block text-gray-500 text-xs uppercase mb-1">Dikembalikan Pada</span>
                        <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali)->format('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs uppercase mb-1">Kondisi Buku</span>
                        <span class="font-medium {{ $peminjaman->pengembalian->kondisi_buku_kembali == 'BAIK' ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $peminjaman->pengembalian->kondisi_buku_kembali }}
                        </span>
                    </div>
                    
                    <div class="sm:col-span-2 mt-2 pt-4 border-t">
                        <span class="block text-gray-500 text-xs uppercase mb-2">Rincian Denda</span>
                        <div class="bg-gray-50 rounded p-3 border">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Denda Keterlambatan</span>
                                <span class="font-medium">Rp {{ number_format($peminjaman->pengembalian->denda_keterlambatan, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Denda Kerusakan</span>
                                <span class="font-medium">Rp {{ number_format($peminjaman->pengembalian->denda_kondisi, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-gray-900 pt-2 border-t mt-2">
                                <span>Total Denda</span>
                                <span class="text-red-600">Rp {{ number_format($peminjaman->pengembalian->denda_total, 0, ',', '.') }}</span>
                            </div>
                            @if($peminjaman->pengembalian->denda_total > 0)
                            <div class="mt-3 pt-3 border-t text-center">
                                <span class="px-2 py-1 text-xs font-bold rounded-full 
                                    {{ $peminjaman->pengembalian->status_denda == 'LUNAS' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                    STATUS: {{ str_replace('_', ' ', $peminjaman->pengembalian->status_denda) }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Informasi Panduan/Aturan -->
    <div class="lg:col-span-1 space-y-6">
        <div class="card p-5 bg-gradient-to-b from-blue-50 to-white">
            <h3 class="font-oswald text-lg font-medium text-gray-800 mb-4 border-b pb-2">Informasi Transaksi</h3>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>ID Transaksi: <strong>#{{ $peminjaman->id_peminjaman }}</strong></span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Petugas (Pinjam): <strong>{{ $peminjaman->adminPinjam->nama_lengkap ?? '-' }}</strong></span>
                </li>
            </ul>
        </div>
        
        @if($peminjaman->status_peminjaman == 'DIPINJAM')
        <div class="card p-5 border border-red-100 bg-red-50 text-red-800">
            <h3 class="font-oswald font-medium text-red-800 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Perhatian
            </h3>
            <p class="text-xs">Harap kembalikan buku tepat waktu. Keterlambatan akan dikenakan denda sesuai dengan peraturan perpustakaan yang berlaku.</p>
        </div>
        @endif
    </div>

</div>
@endsection
