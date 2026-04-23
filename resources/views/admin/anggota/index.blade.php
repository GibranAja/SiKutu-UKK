@extends('layouts.admin')

@section('title', 'Manajemen Anggota - Sikutu')
@section('header', 'Manajemen Anggota')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <form action="{{ route('admin.anggota.index') }}" method="GET" class="w-full sm:w-auto flex-1 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, username..." class="input-field w-full sm:max-w-xs">

        <div class="w-full sm:max-w-[150px]">
            <x-custom-select name="status" :options="['' => 'Semua Status', 'AKTIF' => 'Aktif', 'NONAKTIF' => 'Nonaktif', 'DIBLOKIR' => 'Diblokir']" selected="{{ request('status') }}" placeholder="Semua Status" />
        </div>

        <div class="w-full sm:max-w-[150px]">
            <x-custom-select name="kelas" :options="['' => 'Semua Kelas', '10' => 'Kelas 10', '11' => 'Kelas 11', '12' => 'Kelas 12']" selected="{{ request('kelas') }}" placeholder="Semua Kelas" />
        </div>

        <button type="submit" class="btn-secondary whitespace-nowrap">Filter</button>
        @if(request()->anyFilled(['search', 'status', 'kelas']))
            <a href="{{ route('admin.anggota.index') }}" class="btn-danger whitespace-nowrap bg-gray-500 hover:bg-gray-600 border-none ring-0">Reset</a>
        @endif
    </form>
</div>

<div class="card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">NIS</th>
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Kelas / Jurusan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggotas as $anggota)
                <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $anggota->nis }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $anggota->nama_lengkap }}</div>
                        <div class="text-xs text-gray-500">{{ $anggota->username }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $anggota->jurusan }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.anggota.toggle-status', $anggota->uuid) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-2 py-1 text-xs font-semibold rounded-full transition-colors
                                @if($anggota->status_anggota == 'AKTIF') bg-emerald-100 text-emerald-800 hover:bg-emerald-200
                                @elseif($anggota->status_anggota == 'NONAKTIF') bg-gray-100 text-gray-800 hover:bg-gray-200
                                @else bg-red-100 text-red-800 hover:bg-red-200 @endif" title="Klik untuk mengubah status">
                                {{ $anggota->status_anggota }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.anggota.show', $anggota->uuid) }}" class="text-blue-600 hover:text-blue-900 p-1 inline-block transition-transform hover:scale-110" title="Detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('admin.anggota.edit', $anggota->uuid) }}" class="text-amber-600 hover:text-amber-900 p-1 inline-block transition-transform hover:scale-110" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.anggota.destroy', $anggota->uuid) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1 transition-transform hover:scale-110" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-medium">Data anggota tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($anggotas->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $anggotas->links() }}
    </div>
    @endif
</div>
@endsection
