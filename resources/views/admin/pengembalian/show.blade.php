@extends('layouts.admin')

@section('title', 'Detail Pengembalian - Sikutu')
@section('header', 'Detail Pengembalian')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <a href="{{ route('admin.pengembalian.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Pengembalian
    </a>
    
    @if($pengembalian->status_denda == 'MENUNGGU_KONFIRMASI')
    <div class="flex gap-2">
        <form action="{{ route('admin.pengembalian.terima-pembayaran', $pengembalian->uuid) }}" method="POST" onsubmit="return confirm('Terima pembayaran denda ini?');">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn-primary bg-emerald-600 hover:bg-emerald-700 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Terima Pembayaran
            </button>
        </form>
        <form action="{{ route('admin.pengembalian.tolak-pembayaran', $pengembalian->uuid) }}" method="POST" onsubmit="return confirm('Tolak pembayaran denda ini?');">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Tolak Pembayaran
            </button>
        </form>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-[fadeIn_0.3s_ease-in-out]">
    <!-- Rincian Pengembalian & Denda -->
    <div class="card space-y-4 border-t-4 border-t-emerald-500">
        <h3 class="font-oswald text-lg font-medium text-gray-800 border-b pb-2">Informasi Pengembalian & Denda</h3>
        
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Tanggal Kembali</span>
            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d F Y') }}</span>
        </div>
        
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Kondisi Buku Dikembalikan</span>
            <span class="font-medium {{ $pengembalian->kondisi_buku_kembali == 'BAIK' ? 'text-emerald-600' : 'text-red-600' }}">
                {{ $pengembalian->kondisi_buku_kembali }}
            </span>
        </div>
        
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Denda Keterlambatan</span>
            <span class="font-medium text-gray-800">Rp {{ number_format($pengembalian->denda_keterlambatan, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Denda Kerusakan</span>
            <span class="font-medium text-gray-800">Rp {{ number_format($pengembalian->denda_kondisi, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between border-b border-gray-100 pb-2 pt-2 bg-gray-50 px-2 rounded">
            <span class="text-gray-800 font-bold">Total Denda</span>
            <span class="font-bold text-red-600 text-lg">Rp {{ number_format($pengembalian->denda_total, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Status Pembayaran Denda</span>
            <span class="px-3 py-1 text-xs font-bold rounded-full 
                @if($pengembalian->status_denda == 'LUNAS' || $pengembalian->status_denda == 'TIDAK_ADA') bg-emerald-100 text-emerald-800 
                @elseif($pengembalian->status_denda == 'MENUNGGU_KONFIRMASI') bg-amber-100 text-amber-800 
                @else bg-red-100 text-red-800 @endif">
                {{ str_replace('_', ' ', $pengembalian->status_denda) }}
            </span>
        </div>

        @if($pengembalian->metode_pembayaran)
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Metode Pembayaran</span>
            <span class="font-bold text-gray-800">{{ $pengembalian->metode_pembayaran }}</span>
        </div>
        @endif

        @if($pengembalian->metode_pembayaran === 'TRANSFER' && $pengembalian->bukti_pembayaran)
        <div class="flex justify-between pb-2">
            <span class="text-gray-500">Bukti Transfer</span>
            <a href="{{ Storage::url($pengembalian->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Lihat Bukti
            </a>
        </div>
        @endif

        <div class="flex justify-between border-t pt-2">
            <span class="text-gray-500">Petugas Penerima</span>
            <span class="font-medium text-gray-800">{{ $pengembalian->petugasKembali->nama_lengkap ?? '-' }}</span>
        </div>
        
        @if($pengembalian->catatan_petugas)
        <div class="mt-4">
            <span class="text-gray-500 block mb-1">Catatan Petugas:</span>
            <p class="text-sm text-gray-800 bg-gray-50 p-3 rounded border border-gray-200">{{ $pengembalian->catatan_petugas }}</p>
        </div>
        @endif
    </div>

    <!-- Informasi Peminjaman Asli -->
    <div class="space-y-6">
        <div class="card p-4 border-t-4 border-t-blue-500">
            <h3 class="font-oswald text-base font-medium text-gray-800 mb-4 border-b pb-2 flex justify-between">
                Data Transaksi Awal 
                <a href="{{ route('admin.peminjaman.show', $pengembalian->peminjaman->uuid) }}" class="text-blue-500 text-sm hover:underline flex items-center font-sans font-normal">Lihat Transaksi</a>
            </h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Peminjam</span>
                    <span class="font-medium">{{ $pengembalian->peminjaman->anggota->nama_lengkap ?? 'Anggota Dihapus' }} ({{ $pengembalian->peminjaman->anggota->nis ?? '-' }})</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Buku</span>
                    <span class="font-medium">{{ $pengembalian->peminjaman->buku->judul_buku ?? 'Buku Dihapus' }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Kode Buku</span>
                    <span class="font-medium">{{ $pengembalian->peminjaman->buku->kode_buku ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Tanggal Pinjam</span>
                    <span class="font-medium">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_pinjam)->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between pb-2">
                    <span class="text-gray-500">Batas Waktu Kembali</span>
                    <span class="font-medium">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_harus_kembali)->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
