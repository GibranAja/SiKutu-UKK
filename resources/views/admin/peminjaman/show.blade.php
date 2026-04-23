@extends('layouts.admin')

@section('title', 'Detail Peminjaman - Sikutu')
@section('header', 'Detail Peminjaman')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <a href="{{ route('admin.peminjaman.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Peminjaman
    </a>
    
    @if($peminjaman->status_peminjaman == 'DIPINJAM')
    <div class="flex gap-2">

        <a href="{{ route('admin.pengembalian.create', ['peminjaman' => $peminjaman->id_peminjaman]) }}" class="btn-primary text-sm flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Proses Pengembalian
        </a>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-[fadeIn_0.3s_ease-in-out]">
    <!-- Informasi Peminjaman -->
    <div class="card space-y-4 border-t-4 border-t-blue-500">
        <h3 class="font-oswald text-lg font-medium text-gray-800 border-b pb-2">Informasi Transaksi</h3>
        
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">ID Transaksi</span>
            <span class="font-medium text-gray-800">#{{ $peminjaman->id_peminjaman }}</span>
        </div>
        
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Status Peminjaman</span>
            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                @if($peminjaman->status_peminjaman == 'DIPINJAM') bg-blue-100 text-blue-800 
                @elseif($peminjaman->status_peminjaman == 'DIKEMBALIKAN') bg-emerald-100 text-emerald-800 
                @else bg-red-100 text-red-800 @endif">
                {{ $peminjaman->status_peminjaman }}
            </span>
        </div>
        
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Tanggal Pinjam</span>
            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</span>
        </div>
        
        @php
            $isTerlambat = $peminjaman->status_peminjaman == 'DIPINJAM' && \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->isPast();
            $hariTerlambat = $isTerlambat ? \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->diffInDays(\Carbon\Carbon::now()) : 0;
            $estimasiDenda = $isTerlambat && $pengaturan ? $pengaturan->hitungDendaKeterlambatan($hariTerlambat) : 0;
        @endphp
        
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Tgl Harus Kembali</span>
            <span class="font-medium {{ $isTerlambat ? 'text-red-600 font-bold' : 'text-gray-800' }}">
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->format('d F Y') }}
                @if($isTerlambat) <br><small>(Terlambat {{ $hariTerlambat }} hari)</small> @endif
            </span>
        </div>

        @if($isTerlambat)
        <div class="flex justify-between border-b border-red-100 pb-2 bg-red-50 p-2 rounded">
            <span class="text-red-600 font-medium">Estimasi Denda</span>
            <span class="font-bold text-red-700">Rp {{ number_format($estimasiDenda, 0, ',', '.') }}</span>
        </div>
        @endif
        
        <div class="flex justify-between border-b border-gray-100 pb-2">
            <span class="text-gray-500">Admin Petugas</span>
            <span class="font-medium text-gray-800">{{ $peminjaman->adminPinjam->nama_lengkap ?? '-' }}</span>
        </div>
        
        @if($peminjaman->catatan_peminjaman)
        <div>
            <span class="text-gray-500 block mb-1">Catatan:</span>
            <p class="text-sm text-gray-800 bg-gray-50 p-2 rounded border">{{ $peminjaman->catatan_peminjaman }}</p>
        </div>
        @endif
    </div>

    <div class="space-y-6">
        <!-- Informasi Anggota -->
        <div class="card p-4 flex items-center">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl font-bold uppercase mr-4 flex-shrink-0">
                {{ substr($peminjaman->anggota->nama_lengkap ?? '?', 0, 1) }}
            </div>
            <div>
                <h4 class="text-xs text-gray-500 font-semibold uppercase mb-1">Peminjam</h4>
                <p class="font-oswald text-lg font-medium text-gray-800">{{ $peminjaman->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                <p class="text-sm text-gray-500">NIS: {{ $peminjaman->anggota->nis ?? '-' }} | Kelas: {{ $peminjaman->anggota->kelas ?? '-' }} {{ $peminjaman->anggota->jurusan ?? '-' }}</p>
            </div>
        </div>

        <!-- Informasi Buku -->
        <div class="card p-4 flex items-center">
            @if(isset($peminjaman->buku->gambar_cover))
                <img src="{{ Storage::url($peminjaman->buku->gambar_cover) }}" alt="Cover" class="w-16 h-24 object-cover rounded shadow-sm mr-4 flex-shrink-0">
            @else
                <div class="w-16 h-24 bg-gray-200 rounded flex items-center justify-center text-gray-400 shadow-sm mr-4 flex-shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
            <div>
                <h4 class="text-xs text-gray-500 font-semibold uppercase mb-1">Buku</h4>
                <p class="font-oswald text-lg font-medium text-gray-800 leading-tight">{{ $peminjaman->buku->judul_buku ?? 'Buku Dihapus' }}</p>
                <p class="text-sm text-gray-500 mt-1">Kode: {{ $peminjaman->buku->kode_buku ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

@if($peminjaman->pengembalian)
<div class="mt-6 card border-t-4 border-t-emerald-500 animate-[fadeIn_0.5s_ease-in-out]">
    <h3 class="font-oswald text-lg font-medium text-gray-800 border-b pb-2 mb-4">Informasi Pengembalian</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-3">
            <div class="flex justify-between border-b border-gray-100 pb-2">
                <span class="text-gray-500">Tanggal Kembali</span>
                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali)->format('d F Y') }}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
                <span class="text-gray-500">Kondisi Buku</span>
                <span class="font-medium {{ $peminjaman->pengembalian->kondisi_buku_kembali == 'BAIK' ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $peminjaman->pengembalian->kondisi_buku_kembali }}
                </span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
                <span class="text-gray-500">Petugas Penerima</span>
                <span class="font-medium text-gray-800">{{ $peminjaman->pengembalian->petugasKembali->nama_lengkap ?? '-' }}</span>
            </div>
        </div>
        
        <div class="space-y-3">
            <div class="flex justify-between border-b border-gray-100 pb-2">
                <span class="text-gray-500">Denda Keterlambatan</span>
                <span class="font-medium text-gray-800">Rp {{ number_format($peminjaman->pengembalian->denda_keterlambatan, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
                <span class="text-gray-500">Denda Kerusakan</span>
                <span class="font-medium text-gray-800">Rp {{ number_format($peminjaman->pengembalian->denda_kondisi, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
                <span class="text-gray-500 font-bold">Total Denda</span>
                <span class="font-bold text-red-600">Rp {{ number_format($peminjaman->pengembalian->denda_total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between pb-2">
                <span class="text-gray-500">Status Denda</span>
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    @if($peminjaman->pengembalian->status_denda == 'LUNAS' || $peminjaman->pengembalian->status_denda == 'TIDAK_ADA') bg-emerald-100 text-emerald-800 
                    @else bg-red-100 text-red-800 @endif">
                    {{ str_replace('_', ' ', $peminjaman->pengembalian->status_denda) }}
                </span>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
