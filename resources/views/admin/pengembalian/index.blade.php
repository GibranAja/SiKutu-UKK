@extends('layouts.admin')

@section('title', 'Pengembalian & Denda - Sikutu')
@section('header', 'Manajemen Pengembalian & Denda')

@section('content')

<div class="mb-6 flex space-x-4 border-b border-gray-200">
    <a href="{{ route('admin.pengembalian.index', ['tab' => 'pengembalian']) }}" class="py-2 px-4 font-oswald text-lg {{ $tab === 'pengembalian' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
        Riwayat Pengembalian
    </a>
    <a href="{{ route('admin.pengembalian.index', ['tab' => 'denda']) }}" class="py-2 px-4 font-oswald text-lg {{ $tab === 'denda' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
        Manajemen Denda
    </a>
</div>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <form action="{{ route('admin.pengembalian.index') }}" method="GET" class="w-full sm:w-auto flex-1 flex flex-col sm:flex-row gap-2">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam, buku..." class="input-field w-full sm:max-w-xs">
        
        @if($tab === 'denda')
        <div class="w-full sm:max-w-[150px]">
            <x-custom-select name="status_denda" :options="['' => 'Semua Denda', 'BELUM_LUNAS' => 'Belum Lunas', 'MENUNGGU_KONFIRMASI' => 'Menunggu Konfirmasi', 'LUNAS' => 'Lunas', 'DITOLAK' => 'Ditolak']" selected="{{ request('status_denda') }}" placeholder="Status Denda" />
        </div>
        @endif

        <button type="submit" class="btn-secondary whitespace-nowrap">Filter</button>
        @if(request()->anyFilled(['search', 'status_denda']))
            <a href="{{ route('admin.pengembalian.index', ['tab' => $tab]) }}" class="btn-danger whitespace-nowrap bg-gray-500 hover:bg-gray-600 border-none ring-0">Reset</a>
        @endif
    </form>

    @if($tab === 'pengembalian')
    <a href="{{ route('admin.pengembalian.create') }}" class="btn-primary whitespace-nowrap flex items-center bg-emerald-600 hover:bg-emerald-700">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Proses Pengembalian
    </a>
    @endif
</div>

<div class="card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Peminjam</th>
                    <th class="px-6 py-4">Buku</th>
                    <th class="px-6 py-4">Tgl Kembali</th>
                    @if($tab === 'denda')
                    <th class="px-6 py-4">Denda</th>
                    <th class="px-6 py-4">Pembayaran</th>
                    @endif
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalians as $kembali)
                <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $kembali->peminjaman->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</div>
                        <div class="text-xs text-gray-500">{{ $kembali->peminjaman->anggota->nis ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ Str::limit($kembali->peminjaman->buku->judul_buku ?? 'Buku Dihapus', 30) }}</div>
                        <div class="text-xs text-gray-500">{{ $kembali->kondisi_buku_kembali == 'BAIK' ? 'Kondisi Baik' : 'Kondisi Rusak' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($kembali->tanggal_kembali)->format('d/m/Y') }}
                    </td>
                    @if($tab === 'denda')
                    <td class="px-6 py-4">
                        <div class="font-bold text-red-600">Rp {{ number_format($kembali->denda_total, 0, ',', '.') }}</div>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full mt-1 inline-block
                            @if($kembali->status_denda == 'LUNAS') bg-emerald-100 text-emerald-800 
                            @elseif($kembali->status_denda == 'MENUNGGU_KONFIRMASI') bg-amber-100 text-amber-800 
                            @elseif($kembali->status_denda == 'DITOLAK') bg-red-100 text-red-800 
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ str_replace('_', ' ', $kembali->status_denda) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($kembali->metode_pembayaran)
                            <div class="text-xs font-semibold">{{ $kembali->metode_pembayaran }}</div>
                            @if($kembali->metode_pembayaran === 'TRANSFER' && $kembali->bukti_pembayaran)
                                <a href="{{ Storage::url($kembali->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline text-xs flex items-center mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Lihat Bukti
                                </a>
                            @endif
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    @endif
                    <td class="px-6 py-4 text-right space-x-2">
                        @if($tab === 'denda' && $kembali->status_denda == 'MENUNGGU_KONFIRMASI')
                        <form action="{{ route('admin.pengembalian.terima-pembayaran', $kembali->uuid) }}" method="POST" class="inline-block" onsubmit="return confirm('Terima pembayaran denda ini?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-emerald-600 hover:text-emerald-900 p-1 transition-transform hover:scale-110" title="Terima Pembayaran">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </form>
                        <form action="{{ route('admin.pengembalian.tolak-pembayaran', $kembali->uuid) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak pembayaran denda ini?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1 transition-transform hover:scale-110" title="Tolak Pembayaran">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('admin.pengembalian.show', $kembali->uuid) }}" class="text-blue-600 hover:text-blue-900 p-1 inline-block transition-transform hover:scale-110" title="Detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $tab === 'denda' ? 6 : 4 }}" class="px-6 py-8 text-center text-gray-500 font-medium">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pengembalians->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $pengembalians->appends(['tab' => $tab])->links() }}
    </div>
    @endif
</div>
@endsection
