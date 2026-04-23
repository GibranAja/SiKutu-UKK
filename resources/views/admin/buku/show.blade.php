@extends('layouts.admin')

@section('title', 'Detail Buku - Sikutu')
@section('header', 'Detail Buku')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.buku.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Buku
    </a>
</div>

<div class="card max-w-4xl animate-[fadeIn_0.3s_ease-in-out]">
    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-1/3 flex flex-col items-center">
            @if($buku->gambar_cover)
                <img src="{{ Storage::url($buku->gambar_cover) }}" alt="Cover {{ $buku->judul_buku }}" class="w-full max-w-[250px] rounded-lg shadow-md object-cover">
            @else
                <div class="w-full max-w-[250px] aspect-[2/3] bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 shadow-md">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif

            <div class="mt-4 flex gap-2 w-full max-w-[250px]">
                <a href="{{ route('admin.buku.edit', $buku->uuid) }}" class="btn-primary flex-1 text-center py-2">Edit Buku</a>
            </div>
        </div>

        <div class="w-full md:w-2/3 space-y-4">
            <div>
                <h2 class="text-2xl font-bold font-oswald text-gray-800">{{ $buku->judul_buku }}</h2>
                <p class="text-gray-500 font-medium mt-1">{{ $buku->pengarang }}</p>
            </div>

            <div class="flex flex-wrap gap-2 mt-2">
                @foreach($buku->genres as $genre)
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">{{ $genre->nama_genre }}</span>
                @endforeach
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Kode Buku</p>
                    <p class="font-medium text-gray-900">{{ $buku->kode_buku }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Penerbit</p>
                    <p class="font-medium text-gray-900">{{ $buku->penerbit ?: '-' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Tahun Terbit</p>
                    <p class="font-medium text-gray-900">{{ $buku->tahun_terbit ?: '-' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Jenis Buku</p>
                    <p class="font-medium text-gray-900">{{ $buku->jenis_buku ?: '-' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Stok Tersedia</p>
                    <p class="font-medium text-gray-900">{{ $buku->stok }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Kondisi / Status</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($buku->kondisi == 'BAIK') bg-emerald-100 text-emerald-800
                            @elseif($buku->kondisi == 'RUSAK') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $buku->kondisi }}
                        </span>

                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $buku->status_buku == 'TERSEDIA' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                            {{ str_replace('_', ' ', $buku->status_buku) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6">
                <h3 class="font-oswald font-medium text-lg text-gray-800 mb-4">Riwayat Peminjaman Buku Ini</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Peminjam</th>
                                <th class="px-4 py-3">Tgl Pinjam</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buku->peminjaman->take(5) as $pinjam)
                            <tr class="border-b">
                                <td class="px-4 py-3 font-medium">{{ $pinjam->anggota->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pinjam->tanggal_peminjaman)->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($pinjam->status_peminjaman == 'DIPINJAM') bg-blue-100 text-blue-800
                                        @elseif($pinjam->status_peminjaman == 'DIKEMBALIKAN') bg-emerald-100 text-emerald-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $pinjam->status_peminjaman }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">Belum ada riwayat peminjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
