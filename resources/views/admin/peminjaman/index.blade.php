@extends('layouts.admin')

@section('title', 'Peminjaman Buku - Sikutu')
@section('header', 'Manajemen Peminjaman')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="w-full sm:w-auto flex-1 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam, buku..." class="input-field w-full sm:max-w-xs">

        <div x-data="{ open: false, selected: '{{ request('status') }}', options: {'': 'Semua Status', 'DIPINJAM': 'Dipinjam', 'DIKEMBALIKAN': 'Dikembalikan', 'HILANG': 'Hilang', 'MENUNGGU_KONFIRMASI': 'Menunggu Konfirmasi', 'DITOLAK': 'Ditolak'} }" class="relative z-50 w-full sm:w-auto">
            <button type="button" @click="open = !open" @click.away="open = false" class="input-field w-full sm:min-w-[150px] bg-white py-2 px-3 text-sm flex justify-between items-center text-left">
                <span x-text="options[selected] || 'Pilih Status...'"></span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" class="absolute mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg z-50 py-1" style="display: none;" x-transition>
                <template x-for="(label, value) in options" :key="value">
                    <button type="button" @click="selected = value; open = false; $refs.hiddenInput.value = value; $refs.form.submit()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700" :class="{ 'bg-blue-50 font-bold': selected === value }">
                        <span x-text="label"></span>
                    </button>
                </template>
            </div>
            <input type="hidden" x-ref="hiddenInput" name="status" :value="selected">
        </div>

        <label class="flex items-center text-sm">
            <input type="checkbox" name="terlambat" value="1" {{ request('terlambat') ? 'checked' : '' }} class="mr-2 rounded text-blue-600">
            Hanya Terlambat
        </label>

        <button type="submit" x-ref="form" class="btn-secondary whitespace-nowrap">Filter</button>
        @if(request()->anyFilled(['search', 'status', 'terlambat']))
            <a href="{{ route('admin.peminjaman.index') }}" class="btn-danger whitespace-nowrap bg-gray-500 hover:bg-gray-600 border-none ring-0">Reset</a>
        @endif
    </form>


</div>

<div class="card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Peminjam</th>
                    <th class="px-6 py-4">Buku</th>
                    <th class="px-6 py-4">Tgl Pinjam / Kembali</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                @php
                    $isTerlambat = $peminjaman->status_peminjaman == 'DIPINJAM' && \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->isPast();
                @endphp
                <tr class="border-b hover:bg-gray-50 transition-colors duration-200 {{ $isTerlambat ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $peminjaman->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</div>
                        <div class="text-xs text-gray-500">{{ $peminjaman->anggota->nis ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ Str::limit($peminjaman->buku->judul_buku ?? 'Buku Dihapus', 30) }}</div>
                        <div class="text-xs text-gray-500">{{ $peminjaman->buku->kode_buku ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</div>
                        <div class="text-xs {{ $isTerlambat ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                            Batas: {{ \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->format('d/m/Y') }}
                            @if($isTerlambat) (Terlambat) @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider
                            @if($peminjaman->status_peminjaman == 'DIPINJAM') bg-blue-100 text-blue-800
                            @elseif($peminjaman->status_peminjaman == 'DIKEMBALIKAN') bg-emerald-100 text-emerald-800
                            @elseif($peminjaman->status_peminjaman == 'MENUNGGU_KONFIRMASI') bg-amber-100 text-amber-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ str_replace('_', ' ', $peminjaman->status_peminjaman) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        @if($peminjaman->status_peminjaman == 'MENUNGGU_KONFIRMASI')
                            <form action="{{ route('admin.peminjaman.terima', $peminjaman->uuid) }}" method="POST" class="inline-block" onsubmit="return confirm('Terima peminjaman ini?');">
                                @csrf
                                <button type="submit" class="text-emerald-600 hover:text-emerald-900 p-1 transition-transform hover:scale-110" title="Terima Peminjaman">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </form>
                            <form action="{{ route('admin.peminjaman.tolak', $peminjaman->uuid) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak peminjaman ini?');">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900 p-1 transition-transform hover:scale-110" title="Tolak Peminjaman">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.peminjaman.show', $peminjaman->uuid) }}" class="text-blue-600 hover:text-blue-900 p-1 inline-block transition-transform hover:scale-110" title="Detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-medium">Data peminjaman tidak ditemukan.</td>
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
