@extends('layouts.admin')

@section('title', 'Edit Peminjaman - Sikutu')
@section('header', 'Edit Peminjaman')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.peminjaman.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Peminjaman
    </a>
</div>

<div class="card max-w-4xl animate-[fadeIn_0.3s_ease-in-out]">
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
        <p class="text-sm text-blue-700"><strong>Catatan:</strong> Hanya tanggal kembali dan catatan yang dapat diubah. Untuk buku atau anggota yang salah, harap hapus transaksi ini dan buat baru (jika belum dikembalikan).</p>
    </div>

    <form action="{{ route('admin.peminjaman.update', $peminjaman->uuid) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Anggota Peminjam</label>
                    <input type="text" disabled class="input-field bg-gray-100" value="{{ $peminjaman->anggota->nis ?? '-' }} - {{ $peminjaman->anggota->nama_lengkap ?? '-' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Buku yang Dipinjam</label>
                    <input type="text" disabled class="input-field bg-gray-100" value="{{ $peminjaman->buku->kode_buku ?? '-' }} - {{ $peminjaman->buku->judul_buku ?? '-' }}">
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-5">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Tanggal Pinjam</label>
                        <input type="text" disabled class="input-field bg-gray-100" value="{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}">
                    </div>
                    
                    <div class="flex-1">
                        <label for="tanggal_harus_kembali" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Tanggal Harus Kembali <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_harus_kembali" name="tanggal_harus_kembali" value="{{ old('tanggal_harus_kembali', \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->format('Y-m-d')) }}" required class="input-field">
                        @error('tanggal_harus_kembali') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="catatan_peminjaman" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Catatan (Opsional)</label>
                    <textarea id="catatan_peminjaman" name="catatan_peminjaman" rows="3" class="input-field" placeholder="Tambahkan catatan jika ada">{{ old('catatan_peminjaman', $peminjaman->catatan_peminjaman) }}</textarea>
                    @error('catatan_peminjaman') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end border-t pt-4">
            <button type="submit" class="btn-primary">Update Peminjaman</button>
        </div>
    </form>
</div>
@endsection
