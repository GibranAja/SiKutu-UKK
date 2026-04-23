@extends('layouts.admin')

@section('title', 'Detail Anggota - Sikutu')
@section('header', 'Detail Anggota')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <a href="{{ route('admin.anggota.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Anggota
    </a>
    
    <a href="{{ route('admin.anggota.edit', $anggota->uuid) }}" class="btn-primary text-sm flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        Edit Anggota
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-[fadeIn_0.3s_ease-in-out]">
    <!-- Profil Card -->
    <div class="card md:col-span-1 border-t-4 border-t-blue-500">
        <div class="flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-3xl font-bold uppercase mb-4 shadow-sm">
                {{ substr($anggota->nama_lengkap, 0, 1) }}
            </div>
            <h2 class="text-xl font-bold font-oswald text-gray-800">{{ $anggota->nama_lengkap }}</h2>
            <p class="text-gray-500 text-sm mb-2">{{ $anggota->nis }}</p>
            
            <span class="px-3 py-1 mt-2 text-xs font-semibold rounded-full 
                @if($anggota->status_anggota == 'AKTIF') bg-emerald-100 text-emerald-800 
                @elseif($anggota->status_anggota == 'NONAKTIF') bg-gray-100 text-gray-800 
                @else bg-red-100 text-red-800 @endif">
                Status: {{ $anggota->status_anggota }}
            </span>
            
            <div class="w-full mt-6 space-y-3 text-sm text-left">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Kelas / Jurusan</span>
                    <span class="font-medium text-gray-800">{{ $anggota->kelas }} {{ $anggota->jurusan }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Username</span>
                    <span class="font-medium text-gray-800">{{ $anggota->username }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Tanggal Daftar</span>
                    <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Masa Berlaku</span>
                    <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($anggota->masa_berlaku)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between pb-2">
                    <span class="text-gray-500">Admin Pendaftar</span>
                    <span class="font-medium text-gray-800">{{ $anggota->adminPendaftar->nama_lengkap ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Detail & Riwayat -->
    <div class="md:col-span-2 space-y-6">
        <div class="card">
            <h3 class="font-oswald text-lg font-medium text-gray-800 mb-4 border-b pb-2">Informasi Kontak</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Email</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $anggota->email ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">No Telepon</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $anggota->no_telepon ?: '-' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Alamat</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $anggota->alamat ?: '-' }}</p>
                </div>
            </div>
        </div>

        <div class="card p-0 overflow-hidden">
            <div class="p-4 border-b">
                <h3 class="font-oswald text-lg font-medium text-gray-800">Riwayat Peminjaman Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Buku</th>
                            <th class="px-4 py-3">Tgl Pinjam</th>
                            <th class="px-4 py-3">Tgl Harus Kembali</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota->peminjaman->take(5) as $pinjam)
                        <tr class="border-b">
                            <td class="px-4 py-3 font-medium">{{ $pinjam->buku->judul_buku ?? 'Buku Dihapus' }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pinjam->tanggal_harus_kembali)->format('d/m/Y') }}</td>
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
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada riwayat peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
